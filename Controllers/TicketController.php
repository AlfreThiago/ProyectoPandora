<?php
require_once __DIR__ . '/../Models/Ticket.php';
require_once __DIR__ . '/../Core/Database.php';
require_once __DIR__ . '/../Core/Auth.php';
require_once __DIR__ . '/../Models/Device.php';
require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/HistorialController.php';
require_once __DIR__ . '/../Models/EstadoTicket.php';
require_once __DIR__ . '/../Models/Rating.php';
require_once __DIR__ . '/../Models/TicketEstadoHistorial.php';

class TicketController
{
    private $ticketModel;
    private $deviceModel;
    private $userModel;
    private $estadoModel;
    private $historialController;
    private $histEstadoModel;

    public function __construct()
    {
        $db = new Database();
        $db->connectDatabase();
        $this->ticketModel = new Ticket($db->getConnection());
        $this->deviceModel = new DeviceModel($db->getConnection());
        $this->userModel = new UserModel($db->getConnection());
        $this->estadoModel = new EstadoTicketModel($db->getConnection());
        $this->historialController = new HistorialController();
    $this->histEstadoModel = new TicketEstadoHistorialModel($db->getConnection());
    }

    // Mapa de transiciones válidas (ajustable hasta 8 estados)
    private function transicionesValidas(): array {
        // Nombres deben existir en estados_tickets
        return [
            'Nuevo' => ['Diagnóstico', 'En espera', 'Cancelado'],
            'Diagnóstico' => ['Presupuesto', 'En espera'],
            // En 'Presupuesto' no hay cambios manuales por técnico; cliente decide o supervisor publica
            'Presupuesto' => [],
            // 'En espera' usado para que supervisor publique presupuesto; técnico no cambia desde aquí
            'En espera' => [],
            // Tras reparación, ahora pasa a 'En pruebas' o 'Listo para retirar'
            'En reparación' => ['En pruebas', 'Listo para retirar'],
            // En pruebas: técnico NO finaliza directamente; supervisor define "Listo" y luego pago
            'En pruebas' => ['Listo para retirar'],
            'Listo para retirar' => ['Finalizado'],
            'Finalizado' => [],
            'Cancelado' => []
        ];
    }

    private function puedeTransicionar(string $from, string $to): bool {
        $map = $this->transicionesValidas();
        return in_array($to, $map[$from] ?? [], true);
    }

    // Resolver id de estado por nombre (case-insensitive)
    private function estadoIdPorNombre(string $name): ?int {
        // Comparación case-insensitive y acento-insensitive
        $normalize = function(string $s): string {
            $s = trim($s);
            $map = [
                'Á'=>'A','É'=>'E','Í'=>'I','Ó'=>'O','Ú'=>'U','Ñ'=>'N',
                'á'=>'a','é'=>'e','í'=>'i','ó'=>'o','ú'=>'u','ñ'=>'n'
            ];
            $s = strtr($s, $map);
            return strtolower($s);
        };
        $target = $normalize($name);
        $estados = $this->estadoModel->getAllEstados();
        foreach ($estados as $e) {
            $n = $normalize($e['name'] ?? '');
            if ($n === $target) return (int)$e['id'];
        }
        return null;
    }

    public function ActualizarEstado() {
        $user = Auth::user();
        if (!$user || $user['role'] !== 'Tecnico') {
            header('Location: /ProyectoPandora/Public/index.php?route=Auth/Login');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /ProyectoPandora/Public/index.php?route=Tecnico/MisReparaciones');
            exit;
        }
        $ticket_id = (int)($_POST['ticket_id'] ?? 0);
        $estado_id = (int)($_POST['estado_id'] ?? 0);
        $comentario = trim($_POST['comentario'] ?? '');

        $tk = $this->ticketModel->ver($ticket_id);
        if (!$tk) { header('Location: /ProyectoPandora/Public/index.php?route=Tecnico/MisReparaciones&error=tk'); exit; }

        // Obtener nombres de estado actual y nuevo
        $estadoActual = $tk['estado'] ?? '';
        $nuevo = $this->estadoModel->getById($estado_id);
        if (!$nuevo) { header('Location: /ProyectoPandora/Public/index.php?route=Tecnico/MisReparaciones&error=estado'); exit; }
        $estadoNuevo = $nuevo['name'];

        // Validar transición (y bloquear finalización por técnico)
        if (!$this->puedeTransicionar($estadoActual, $estadoNuevo) || strcasecmp($estadoNuevo, 'Finalizado')===0) {
            header('Location: /ProyectoPandora/Public/index.php?route=Ticket/Ver&id='.$ticket_id.'&error=transicion');
            exit;
        }

        // Regla de presupuesto: antes de "En reparación" debe existir presupuesto guardado y aprobado por el cliente
        if (strcasecmp($estadoNuevo, 'En reparación') === 0) {
            // Verificar que el total esté calculado (usa TicketLabor + items)
            // Simplificación: si no hay items y mano_obra == 0, bloquear
            require_once __DIR__ . '/../Models/TicketLabor.php';
            require_once __DIR__ . '/../Models/ItemTicket.php';
            $db = new Database(); $db->connectDatabase();
            $laborModel = new TicketLaborModel($db->getConnection());
            $itemModel = new ItemTicketModel($db->getConnection());
            $items = $itemModel->listarPorTicket($ticket_id);
            $hasItems = !empty($items);
            $labor = $laborModel->getByTicket($ticket_id);
            $mano = (float)($labor['labor_amount'] ?? 0);
            if (!$hasItems || $mano <= 0) {
                header('Location: /ProyectoPandora/Public/index.php?route=Ticket/Ver&id='.$ticket_id.'&error=presupuesto');
                exit;
            }
            // Verificar aprobación del cliente (usaremos ticket_estado_historial con user_role=Cliente y comentario 'Aprobado')
            $aprobado = false;
            $hist = $this->histEstadoModel->listByTicket($ticket_id);
            foreach ($hist as $ev) {
                if ($ev['user_role']==='Cliente' && stripos($ev['comentario'] ?? '', 'aprob') !== false) { $aprobado = true; break; }
            }
            if (!$aprobado) {
                header('Location: /ProyectoPandora/Public/index.php?route=Ticket/Ver&id='.$ticket_id.'&error=aprobacion');
                exit;
            }
        }

        // Actualizar estado del ticket
        // Obtener id de estado por nombre si fuera necesario, aquí ya lo tenemos
        $conn = (new Database());
        $conn->connectDatabase();
        $dbConn = $conn->getConnection();
        $stmt = $dbConn->prepare("UPDATE tickets SET estado_id = ? WHERE id = ?");
        $stmt->bind_param("ii", $estado_id, $ticket_id);
        $stmt->execute();

        // Registrar historial
        $this->histEstadoModel->add($ticket_id, $estado_id, (int)$user['id'], $user['role'], $comentario);

        header('Location: /ProyectoPandora/Public/index.php?route=Ticket/Ver&id='.$ticket_id.'&ok=estado');
        exit;
    }

    // Cliente aprueba presupuesto
    public function AprobarPresupuesto() {
        $user = Auth::user();
        if (!$user || $user['role'] !== 'Cliente') {
            header('Location: /ProyectoPandora/Public/index.php?route=Auth/Login');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /ProyectoPandora/Public/index.php?route=Cliente/MisTicket');
            exit;
        }
        $ticket_id = (int)($_POST['ticket_id'] ?? 0);
        $comentario = trim($_POST['comentario'] ?? 'Aprobado presupuesto');

        $tk = $this->ticketModel->ver($ticket_id);
        if (!$tk) { header('Location: /ProyectoPandora/Public/index.php?route=Cliente/MisTicket&error=ticket'); exit; }

        // Validar pertenencia
        $db = new Database(); $db->connectDatabase(); $conn = $db->getConnection();
        $stmtC = $conn->prepare("SELECT id FROM clientes WHERE user_id = ? LIMIT 1");
        $stmtC->bind_param("i", $user['id']);
        $stmtC->execute();
        $cliente = $stmtC->get_result()->fetch_assoc();
        $stmtT = $conn->prepare("SELECT cliente_id FROM tickets WHERE id = ? LIMIT 1");
        $stmtT->bind_param("i", $ticket_id);
        $stmtT->execute();
        $rowT = $stmtT->get_result()->fetch_assoc();
        if (!$cliente || (int)($rowT['cliente_id'] ?? 0) !== (int)$cliente['id']) {
            header('Location: /ProyectoPandora/Public/index.php?route=Cliente/MisTicket&error=forbidden');
            exit;
        }

        // Solo si está en Presupuesto
        $estadoActual = strtolower(trim($tk['estado'] ?? ''));
        if ($estadoActual !== 'presupuesto') {
            header('Location: /ProyectoPandora/Public/index.php?route=Ticket/Ver&id='.$ticket_id.'&error=estado_actual');
            exit;
        }

    // Cambiar a "En reparación" directamente tras aprobación del cliente
    $estadoId = $this->estadoIdPorNombre('En reparación');
        if ($estadoId) {
            $stmtU = $conn->prepare("UPDATE tickets SET estado_id = ? WHERE id = ?");
            $stmtU->bind_param("ii", $estadoId, $ticket_id);
            $stmtU->execute();
        } else {
            // Si no existe, mantener estado actual para no romper
            $estadoId = $this->estadoIdPorNombre('Presupuesto');
        }

        $this->histEstadoModel->add($ticket_id, (int)$estadoId, (int)$user['id'], 'Cliente', $comentario);
        header('Location: /ProyectoPandora/Public/index.php?route=Ticket/Ver&id='.$ticket_id.'&ok=aprobado');
        exit;
    }

    // Supervisor marca ticket como "Listo para retirar"
    public function MarcarListoParaRetirar() {
        $user = Auth::user();
        if (!$user || ($user['role'] ?? '') !== 'Supervisor') {
            header('Location: /ProyectoPandora/Public/index.php?route=Auth/Login');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /ProyectoPandora/Public/index.php?route=Supervisor/Asignar');
            exit;
        }
        $ticket_id = (int)($_POST['ticket_id'] ?? 0);
        if ($ticket_id <= 0) {
            header('Location: /ProyectoPandora/Public/index.php?route=Supervisor/Asignar&error=ticket');
            exit;
        }
        $estadoId = $this->estadoIdPorNombre('Listo para retirar');
        if ($estadoId) {
            $db = new Database(); $db->connectDatabase(); $conn = $db->getConnection();
            $stmtU = $conn->prepare("UPDATE tickets SET estado_id = ? WHERE id = ?");
            $stmtU->bind_param("ii", $estadoId, $ticket_id);
            $stmtU->execute();

            // Registrar historial de estado para auditoría
            $this->histEstadoModel->add($ticket_id, (int)$estadoId, (int)$user['id'], 'Supervisor', 'Marcado como listo para retirar');

            // Notificar al cliente por correo (en cola)
            require_once __DIR__ . '/../Models/MailQueue.php';
            $stmtMail = $conn->prepare("SELECT u.email FROM tickets t INNER JOIN clientes c ON c.id=t.cliente_id INNER JOIN users u ON u.id=c.user_id WHERE t.id=? LIMIT 1");
            if ($stmtMail) {
                $stmtMail->bind_param('i', $ticket_id);
                $stmtMail->execute();
                $em = $stmtMail->get_result()->fetch_assoc();
                if ($em && !empty($em['email'])) {
                    $mq = new MailQueueModel($conn);
                    $mq->enqueue($em['email'], 'Listo para retirar', 'Hola, tu equipo del ticket #'.$ticket_id.' está listo para retirar.');
                }
            }
        }
        header('Location: /ProyectoPandora/Public/index.php?route=Ticket/Ver&id=' . $ticket_id . '&ok=listo');
        exit;
    }

    // Supervisor marca ticket como pagado y finaliza
    public function MarcarPagadoYFinalizar() {
        $user = Auth::user();
        if (!$user || ($user['role'] ?? '') !== 'Supervisor') {
            header('Location: /ProyectoPandora/Public/index.php?route=Auth/Login');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /ProyectoPandora/Public/index.php?route=Supervisor/Asignar');
            exit;
        }
        $ticket_id = (int)($_POST['ticket_id'] ?? 0);
        if ($ticket_id <= 0) {
            header('Location: /ProyectoPandora/Public/index.php?route=Supervisor/Asignar&error=ticket');
            exit;
        }
        // Datos de pago (opcionales; si no viene monto, se calcula del presupuesto)
        $amount = isset($_POST['amount']) ? (float)$_POST['amount'] : null;
        $method = strtoupper(trim($_POST['method'] ?? 'EFECTIVO'));
        $reference = trim($_POST['reference'] ?? '');
        // Validar que el cliente haya aprobado el presupuesto
        require_once __DIR__ . '/../Models/TicketEstadoHistorial.php';
        $dbA = new Database(); $dbA->connectDatabase(); $histM = new TicketEstadoHistorialModel($dbA->getConnection());
        $aprobado = false; foreach ($histM->listByTicket($ticket_id) as $ev) { if ($ev['user_role']==='Cliente' && stripos($ev['comentario'] ?? '', 'aprob') !== false) { $aprobado = true; break; } }
        if (!$aprobado) {
            header('Location: /ProyectoPandora/Public/index.php?route=Ticket/Ver&id=' . $ticket_id . '&error=aprobacion');
            exit;
        }
        // Primero aseguramos que esté en Listo para retirar
        $estadoListo = $this->estadoIdPorNombre('Listo para retirar');
        $estadoFinal = $this->estadoIdPorNombre('Finalizado');
        $db = new Database(); $db->connectDatabase(); $conn = $db->getConnection();
        if ($estadoListo && $estadoFinal) {
            // Si aún no está en "Listo para retirar", moverlo
            $stmtC = $conn->prepare("SELECT e.name as estado FROM tickets t INNER JOIN estados_tickets e ON e.id=t.estado_id WHERE t.id=? LIMIT 1");
            $stmtC->bind_param('i', $ticket_id);
            $stmtC->execute();
            $row = $stmtC->get_result()->fetch_assoc();
            $estadoActual = strtolower(trim($row['estado'] ?? ''));
            if ($estadoActual !== 'listo para retirar') {
                $stmtU1 = $conn->prepare("UPDATE tickets SET estado_id = ? WHERE id = ?");
                $stmtU1->bind_param('ii', $estadoListo, $ticket_id);
                $stmtU1->execute();

                // Registrar historial por cambio a "Listo para retirar" previo a finalizar
                $this->histEstadoModel->add($ticket_id, (int)$estadoListo, (int)$user['id'], 'Supervisor', 'Marcado como listo para retirar previo a pago');
            }
            // Finalizar
            $stmtU2 = $conn->prepare("UPDATE tickets SET estado_id = ?, fecha_cierre = NOW() WHERE id = ?");
            $stmtU2->bind_param('ii', $estadoFinal, $ticket_id);
            $stmtU2->execute();

            // Registrar historial de finalización con pago
            $this->histEstadoModel->add($ticket_id, (int)$estadoFinal, (int)$user['id'], 'Supervisor', 'Pago registrado y ticket finalizado');

            // Registrar pago (calcular total si no se informó amount)
            require_once __DIR__ . '/../Models/ItemTicket.php';
            require_once __DIR__ . '/../Models/TicketLabor.php';
            require_once __DIR__ . '/../Models/Pago.php';
            $itemModel = new ItemTicketModel($conn);
            $laborModel = new TicketLaborModel($conn);
            $items = $itemModel->listarPorTicket($ticket_id); $subtotal = 0.0; foreach($items as $it){ $subtotal += (float)($it['valor_total'] ?? 0); }
            $labor = $laborModel->getByTicket($ticket_id); $mano = (float)($labor['labor_amount'] ?? 0);
            $totalCalc = $subtotal + $mano;
            if ($amount === null || $amount <= 0) { $amount = $totalCalc; }
            $metodosValidos = ['EFECTIVO','TARJETA','TRANSFERENCIA','OTRO'];
            if (!in_array($method, $metodosValidos, true)) { $method = 'EFECTIVO'; }
            $pago = new PagoModel($conn);
            $pago->add($ticket_id, (float)$amount, $method, $reference, (int)$user['id']);
        }
        header('Location: /ProyectoPandora/Public/index.php?route=Ticket/Ver&id=' . $ticket_id . '&ok=pagado');
        exit;
    }

    // Cliente rechaza presupuesto
    public function RechazarPresupuesto() {
        $user = Auth::user();
        if (!$user || $user['role'] !== 'Cliente') {
            header('Location: /ProyectoPandora/Public/index.php?route=Auth/Login');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /ProyectoPandora/Public/index.php?route=Cliente/MisTicket');
            exit;
        }
        $ticket_id = (int)($_POST['ticket_id'] ?? 0);
        $comentario = trim($_POST['comentario'] ?? 'Rechazado presupuesto');

        $tk = $this->ticketModel->ver($ticket_id);
        if (!$tk) { header('Location: /ProyectoPandora/Public/index.php?route=Cliente/MisTicket&error=ticket'); exit; }

        // Validar pertenencia
        $db = new Database(); $db->connectDatabase(); $conn = $db->getConnection();
        $stmtC = $conn->prepare("SELECT id FROM clientes WHERE user_id = ? LIMIT 1");
        $stmtC->bind_param("i", $user['id']);
        $stmtC->execute();
        $cliente = $stmtC->get_result()->fetch_assoc();
    $stmtT = $conn->prepare("SELECT cliente_id FROM tickets WHERE id = ? LIMIT 1");
    $stmtT->bind_param("i", $ticket_id);
    $stmtT->execute();
    $rowT = $stmtT->get_result()->fetch_assoc();
        if (!$cliente || (int)($rowT['cliente_id'] ?? 0) !== (int)$cliente['id']) {
            header('Location: /ProyectoPandora/Public/index.php?route=Cliente/MisTicket&error=forbidden');
            exit;
        }

        // Solo si está en Presupuesto
        $estadoActual = strtolower(trim($tk['estado'] ?? ''));
        if ($estadoActual !== 'presupuesto') {
            header('Location: /ProyectoPandora/Public/index.php?route=Ticket/Ver&id='.$ticket_id.'&error=estado_actual');
            exit;
        }

        // Cambiar a "Cancelado" si existe, y registrar historial con comentario de rechazo
        $estadoId = $this->estadoIdPorNombre('Cancelado') ?? $this->estadoIdPorNombre('Finalizado');
        if ($estadoId) {
            $stmtU = $conn->prepare("UPDATE tickets SET estado_id = ? WHERE id = ?");
            $stmtU->bind_param("ii", $estadoId, $ticket_id);
            $stmtU->execute();
        }
        $this->histEstadoModel->add($ticket_id, (int)$estadoId, (int)$user['id'], 'Cliente', $comentario);
        header('Location: /ProyectoPandora/Public/index.php?route=Ticket/Ver&id='.$ticket_id.'&ok=rechazado');
        exit;
    }

    public function mostrarLista()
    {
        $user = Auth::user();
        if (!$user) {
            header('Location: /ProyectoPandora/Public/index.php?route=Auth/Login');
            exit;
        }
        if ($user['role'] === 'Administrador') {
            header('Location: /ProyectoPandora/Public/index.php?route=Default/Index');
            exit;
        }
        $tickets = $this->ticketModel->listar();
        $data = [];
        while ($row = $tickets->fetch_assoc()) {
            $data[] = $row;
        }
        include __DIR__ . '/../Views/Ticket/ListarTickets.php';
    }

    public function verTicket($id)
    {
        $user = Auth::user();
        if (!$user) {
            header('Location: /ProyectoPandora/Public/index.php?route=Auth/Login');
            exit;
        }

        // Solo permite acceso a roles válidos
    $rolesPermitidos = ['Supervisor', 'Tecnico', 'Cliente'];
        if (!in_array($user['role'], $rolesPermitidos)) {
            header('Location: /ProyectoPandora/Public/index.php?route=Default/Index');
            exit;
        }

        $ticket = $this->ticketModel->ver($id);

        // Si es cliente, verifica que el ticket le pertenezca
        if ($user['role'] === 'Cliente') {
            if ($ticket['cliente'] !== $user['name']) {
                header('Location: /ProyectoPandora/Public/index.php?route=Cliente/MisTicket');
                exit;
            }
        }

        include __DIR__ . '/../Views/Ticket/VerTicket.php';
    }

    public function Calificar() {
        $user = Auth::user();
        if (!$user || $user['role'] !== 'Cliente') {
            header('Location: /ProyectoPandora/Public/index.php?route=Auth/Login');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /ProyectoPandora/Public/index.php?route=Cliente/MisTicket');
            exit;
        }
        $ticket_id = (int)($_POST['ticket_id'] ?? 0);
        $stars = max(1, min(5, (int)($_POST['stars'] ?? 0)));
        $comment = trim($_POST['comment'] ?? '');

        $db = new Database();
        $db->connectDatabase();
        $ticketModel = new Ticket($db->getConnection());
        $ratingModel = new RatingModel($db->getConnection());

        $tk = $ticketModel->ver($ticket_id);
        if (!$tk) { header('Location: /ProyectoPandora/Public/index.php?route=Cliente/MisTicket&error=ticket'); exit; }

        // Validar que el estado sea Finalizado/Cerrado antes de permitir calificar
        $estadoTxt = strtolower(trim($tk['estado'] ?? ''));
        if (!in_array($estadoTxt, ['finalizado', 'cerrado'], true)) {
            header('Location: /ProyectoPandora/Public/index.php?route=Ticket/Ver&id=' . $ticket_id . '&error=estado');
            exit;
        }

        // Resolver ids relacionales
        $conn = $db->getConnection();
        $stmtC = $conn->prepare("SELECT id FROM clientes WHERE user_id = ? LIMIT 1");
        $stmtC->bind_param("i", $user['id']);
        $stmtC->execute();
        $cliente = $stmtC->get_result()->fetch_assoc();
        // Obtener tecnico y cliente propietario del ticket
        $stmtT = $conn->prepare("SELECT t.tecnico_id, t.cliente_id FROM tickets t WHERE t.id = ? LIMIT 1");
        $stmtT->bind_param("i", $ticket_id);
        $stmtT->execute();
        $rowT = $stmtT->get_result()->fetch_assoc();
        $tecnico_id = $rowT['tecnico_id'] ?? null;
        $owner_cliente_id = $rowT['cliente_id'] ?? null;

        // Validar pertenencia del ticket y existencia de técnico asignado
        if (!$cliente || !$tecnico_id || (int)$owner_cliente_id !== (int)$cliente['id']) {
            header('Location: /ProyectoPandora/Public/index.php?route=Cliente/MisTicket&error=forbidden');
            exit;
        }

        $ratingModel->save($ticket_id, (int)$tecnico_id, (int)$cliente['id'], $stars, $comment);
        header('Location: /ProyectoPandora/Public/index.php?route=Ticket/Ver&id=' . $ticket_id . '&rated=1');
        exit;
    }

    // Supervisor publica presupuesto: cambia estado a 'Presupuesto' y registra historial con total
    public function PublicarPresupuesto() {
        $user = Auth::user();
        if (!$user || ($user['role'] ?? '') !== 'Supervisor') {
            header('Location: /ProyectoPandora/Public/index.php?route=Auth/Login');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /ProyectoPandora/Public/index.php?route=Supervisor/Presupuestos');
            exit;
        }
        $ticket_id = (int)($_POST['ticket_id'] ?? 0);
        if ($ticket_id <= 0) {
            header('Location: /ProyectoPandora/Public/index.php?route=Supervisor/Presupuestos&error=ticket');
            exit;
        }

        // Calcular total: items + mano de obra
        require_once __DIR__ . '/../Models/ItemTicket.php';
        require_once __DIR__ . '/../Models/TicketLabor.php';
        $db = new Database(); $db->connectDatabase(); $conn = $db->getConnection();
        $itemModel = new ItemTicketModel($conn);
        $laborModel = new TicketLaborModel($conn);
        $items = $itemModel->listarPorTicket($ticket_id);
        $subtotal = 0.0;
        foreach ($items as $it) { $subtotal += (float)($it['valor_total'] ?? 0); }
        $labor = $laborModel->getByTicket($ticket_id);
        $mano = (float)($labor['labor_amount'] ?? 0);
        // Validar que el presupuesto esté listo: requiere items y mano de obra definida
        if (empty($items) || $mano <= 0) {
            header('Location: /ProyectoPandora/Public/index.php?route=Supervisor/Presupuestos&error=presupuesto_incompleto');
            exit;
        }
        $total = $subtotal + $mano;

        // Cambiar a estado Presupuesto si existe
        $estadoId = $this->estadoIdPorNombre('Presupuesto');
        if ($estadoId) {
            $stmtU = $conn->prepare("UPDATE tickets SET estado_id = ? WHERE id = ?");
            $stmtU->bind_param("ii", $estadoId, $ticket_id);
            $stmtU->execute();
        } else {
            $estadoId = $this->estadoIdPorNombre('En espera') ?? 0; // fallback visual
        }

        // Historial: publicar presupuesto con total
        $comentario = 'Presupuesto publicado. Total $' . number_format($total, 2, '.', '');
        $this->histEstadoModel->add($ticket_id, (int)$estadoId, (int)$user['id'], 'Supervisor', $comentario);

        // Notificar al cliente por correo en cola
        require_once __DIR__ . '/../Models/MailQueue.php';
        $stmtMail = $conn->prepare("SELECT u.email FROM tickets t INNER JOIN clientes c ON c.id=t.cliente_id INNER JOIN users u ON u.id=c.user_id WHERE t.id=? LIMIT 1");
        if ($stmtMail) {
            $stmtMail->bind_param('i', $ticket_id);
            $stmtMail->execute();
            $em = $stmtMail->get_result()->fetch_assoc();
            if ($em && !empty($em['email'])) {
                $mq = new MailQueueModel($conn);
                $mq->enqueue($em['email'], 'Presupuesto publicado', 'Hola, ya podés revisar y aprobar/rechazar el presupuesto de tu ticket #'.$ticket_id.'.');
            }
        }

        header('Location: /ProyectoPandora/Public/index.php?route=Supervisor/Presupuestos&ok=publicado');
        exit;
    }

    public function edit($id)
    {
        $user = Auth::user();
        $rol = $user['role'];
        if ($rol === 'Administrador') {
            header('Location: /ProyectoPandora/Public/index.php?route=Default/Index');
            exit;
        }
        $ticket = $this->ticketModel->ver($id);
        $estados = $this->estadoModel->getAllEstados();
        $tecnicos = $this->userModel->getAllTecnicos();

        include_once __DIR__ . '/../Views/Ticket/ActualizarTicket.php';
    }

    public function actualizar()
    {
        $user = Auth::user();
        $rol = $user['role'];
        $id = $_POST['id'];
        $descripcion = $_POST['descripcion_falla'];

        $estado_id = $_POST['estado_id'] ?? null;
        $tecnico_id = $_POST['tecnico_id'] ?? null;
        if ($tecnico_id === '' || $tecnico_id === null) {
            $tecnico_id = null;
        }

        // Obtener el técnico anterior (si existía)
        $ticketActual = $this->ticketModel->ver($id);
        $old_tecnico_id = $ticketActual['tecnico_id'] ?? null;

        $this->ticketModel->actualizarCompleto($id, $descripcion, $estado_id, $tecnico_id);

        // Nota: la disponibilidad del técnico se gestiona desde su perfil por el propio técnico.

        // Redirección según rol
        if ($rol === 'Cliente') {
            header('Location: /ProyectoPandora/Public/index.php?route=Cliente/MisTicket');
        } else {
            header('Location: /ProyectoPandora/Public/index.php?route=Ticket/Listar');
        }
        exit;
    }

    public function mostrarCrear()
    {
        $user = Auth::user();
        if (!$user) {
            header('Location: /ProyectoPandora/Public/index.php?route=Auth/Login');
            exit;
        }

    $isAdmin = false; // Administrador no gestiona tickets
        $clientes = [];
        $cliente_id = null;

        if ($isAdmin) {
            $db = new Database();
            $db->connectDatabase();
            $userModel = new UserModel($db->getConnection());
            $clientes = $userModel->getAllClientes();

            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cliente_id'])) {
                $cliente_id = $_POST['cliente_id'];
            }
        } else {
            $cliente = $this->ticketModel->obtenerClientePorUser($user['id']);
            $cliente_id = $cliente['id'];
        }

        $data = [];
        if ($cliente_id) {
            $dispositivos = $this->ticketModel->obtenerDispositivosPorCliente($cliente_id);
            while ($row = $dispositivos->fetch_assoc()) {
                $data[] = $row;
            }
        }

        // Verifica que existan estados
        $estados = $this->estadoModel->getAllEstados();
        if (empty($estados)) {
            $errorMsg = "Primero debes crear al menos un estado antes de poder crear un ticket.";
            include __DIR__ . '/../Views/Ticket/CrearTicket.php';
            return;
        }

        // Verifica que existan dispositivos
        if (empty($data)) {
            $errorMsg = "Primero debes crear al menos un dispositivo antes de poder crear un ticket.";
            include __DIR__ . '/../Views/Ticket/CrearTicket.php';
            return;
        }

        include __DIR__ . '/../Views/Ticket/CrearTicket.php';
    }

    public function crear()
    {
        $user = Auth::user();
        if (!$user) {
            header('Location: /ProyectoPandora/Public/index.php?route=Auth/Login');
            exit;
        }

        if (isset($_POST['recarga_cliente']) && $_POST['recarga_cliente'] === '1') {
            $this->mostrarCrear();
            return;
        }

    $isAdmin = false; // Administrador no gestiona tickets
        if ($isAdmin && isset($_POST['cliente_id'])) {
            $cliente_id = $_POST['cliente_id'];
        } else {
            $cliente = $this->ticketModel->obtenerClientePorUser($user['id']);
            if (!$cliente) {
                die("Error: el usuario no tiene cliente asociado.");
            }
            $cliente_id = $cliente['id'];
        }

        $dispositivo_id = $_POST['dispositivo_id'] ?? '';
        $descripcion = $_POST['descripcion'] ?? '';

        if (empty($dispositivo_id)) {
            header('Location: /ProyectoPandora/Public/index.php?route=Ticket/mostrarCrear&error=Debe seleccionar un dispositivo');
            exit;
        }

        $this->ticketModel->crear($cliente_id, $dispositivo_id, $descripcion);

        // Historial: creación de ticket
        $accion = "Creación de ticket";
        $detalle = "Usuario {$user['name']} creó un ticket para el dispositivo ID {$dispositivo_id} con descripción: {$descripcion}";
        $this->historialController->agregarAccion($accion, $detalle);

        // Redirección según rol
        if ($user['role'] === 'Cliente') {
            header('Location: /ProyectoPandora/Public/index.php?route=Cliente/MisTicket');
        } else {
            header('Location: /ProyectoPandora/Public/index.php?route=Ticket/Listar');
        }
        exit;
    }

    public function eliminar()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header("Location: /ProyectoPandora/Public/index.php?route=Ticket/Listar&error=ID de ticket no especificado");
            exit;
        }
        $user = Auth::user();
        if (!$user) {
            header('Location: /ProyectoPandora/Public/index.php?route=Auth/Login');
            exit;
        }
        if ($user['role'] === 'Administrador') {
            header('Location: /ProyectoPandora/Public/index.php?route=Default/Index');
            exit;
        }
        if ($this->ticketModel->deleteTicket($id)) {
            $accion = "Eliminación de ticket";
            $detalle = "Usuario {$user['name']} eliminó el ticket ID {$id}";
            $this->historialController->agregarAccion($accion, $detalle);

            header("Location: /ProyectoPandora/Public/index.php?route=Ticket/Listar&success=1");
        } else {
            header("Location: /ProyectoPandora/Public/index.php?route=Ticket/Listar&error=No se pudo eliminar el ticket");
        }
        exit;
    }

    public function mostrarCrearItem()
    {
        $user = Auth::user();
        if (!$user) {
            header('Location: /ProyectoPandora/Public/index.php?route=Auth/Login');
            exit;
        }

        $db = new Database();
        $db->connectDatabase();
        $categoryModel = new CategoryModel($db->getConnection());
        $categorias = $categoryModel->getAllInventarioCategories();

        if (empty($categorias)) {
            $errorMsg = "Primero debes crear al menos una categoría de inventario antes de poder agregar un item.";
            include_once __DIR__ . '/../Views/Inventario/CrearItem.php';
            return;
        }

        // ... lógica normal para mostrar el formulario ...
        include_once __DIR__ . '/../Views/Inventario/CrearItem.php';
    }

    // Devuelve el estado actual del ticket en JSON para refresco cliente
    public function EstadoJson()
    {
        $id = (int)($_GET['id'] ?? 0);
        $accept = $_SERVER['HTTP_ACCEPT'] ?? '';
        $xhr = $_SERVER['HTTP_X_REQUESTED_WITH'] ?? '';
        $wantsJson = (stripos($accept, 'application/json') !== false) || (strcasecmp($xhr, 'XMLHttpRequest') === 0) || (($_GET['ajax'] ?? '') === '1');
        if (!$wantsJson) {
            $dest = '/ProyectoPandora/Public/index.php?route=Ticket/Ver' . ($id ? ('&id='.(int)$id) : '');
            header('Location: '.$dest);
            exit;
        }

        $user = Auth::user();
        if (!$user) {
            http_response_code(401);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'unauthorized']);
            return;
        }
        if (!$id) {
            http_response_code(400);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'missing id']);
            return;
        }

        $tk = $this->ticketModel->ver($id);
        if (!$tk) {
            http_response_code(404);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'not found']);
            return;
        }

        // Autorización básica: supervisor/tecnico ven todo; cliente solo si es suyo
        if ($user['role'] === 'Cliente') {
            if (($tk['cliente'] ?? '') !== ($user['name'] ?? '')) {
                http_response_code(403);
                header('Content-Type: application/json');
                echo json_encode(['error' => 'forbidden']);
                return;
            }
        }

        header('Content-Type: application/json');
        echo json_encode([
            'id' => (int)$tk['id'],
            'estado' => $tk['estado'] ?? null,
            'fecha_cierre' => $tk['fecha_cierre'] ?? null,
            'ts' => time(),
        ]);
    }
}
