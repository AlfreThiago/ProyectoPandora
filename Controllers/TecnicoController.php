<?php    
require_once __DIR__ . '/../Core/Auth.php';
require_once __DIR__ . '/../Models/Ticket.php';
require_once __DIR__ . '/../Models/Inventario.php';
require_once __DIR__ . '/../Models/ItemTicket.php';
require_once __DIR__ . '/../Models/TicketLabor.php';
require_once __DIR__ . '/../Models/Rating.php';
require_once __DIR__ . '/../Models/TecnicoStats.php';
require_once __DIR__ . '/../Core/Database.php';
require_once __DIR__ . '/HistorialController.php';

class TecnicoController {  
    private $db;
    private $historial;

    public function __construct() {
        $this->db = new Database();
        $this->db->connectDatabase();
        $this->historial = new HistorialController();
    }

    public function PanelTecnico() {
        header('Location: /ProyectoPandora/Public/index.php?route=Tecnico/MisReparaciones');
        exit;
    }

    public function MisReparaciones() {
        $user = Auth::user();
        if (!$user || $user['role'] !== 'Tecnico') {
            header('Location: /ProyectoPandora/Public/index.php?route=Auth/Login');
            exit;
        }

    $ticketModel = new Ticket($this->db->getConnection());

        // Obtener tickets asignados al técnico
        $tickets = $ticketModel->getTicketsByTecnicoId($user['id']);

        include_once __DIR__ . '/../Views/Tecnicos/MisReparaciones.php';
    }

    public function MisRepuestos() {
        $user = Auth::user();
        if (!$user || $user['role'] !== 'Tecnico') {
            header('Location: /ProyectoPandora/Public/index.php?route=Auth/Login');
            exit;
        }

        $ticketModel = new Ticket($this->db->getConnection());
    $inventarioModel = new InventarioModel($this->db->getConnection());
    $categorias = $inventarioModel->listarCategorias();

        // Tickets del técnico (por user_id)
        $tickets = $ticketModel->getTicketsByTecnicoId($user['id']);

        // Filtros de inventario
        $categoria_id = isset($_GET['categoria_id']) ? (int)$_GET['categoria_id'] : null;
        $buscar = isset($_GET['q']) ? trim($_GET['q']) : '';
        $page = max(1, (int)($_GET['page'] ?? 1));
        $perPage = max(1, min(50, (int)($_GET['perPage'] ?? 10)));
        $sort = $_GET['sort'] ?? 'i.id';
        $dir = $_GET['dir'] ?? 'DESC';
        $offset = ($page - 1) * $perPage;

        if (method_exists($inventarioModel, 'contarFiltrado')) {
            $total = $inventarioModel->contarFiltrado($categoria_id, $buscar);
        } else {
            $total = 0;
        }
        if (method_exists($inventarioModel, 'listarFiltrado')) {
            $items = $inventarioModel->listarFiltrado($categoria_id, $buscar, $perPage, $offset, $sort, $dir);
        } else {
            $items = $inventarioModel->listar();
        }
        $totalPages = $perPage > 0 ? (int)ceil(($total ?: count($items)) / $perPage) : 1;

        // Si viene ticket_id, cargar items solicitados de ese ticket
        $itemTicketModel = new ItemTicketModel($this->db->getConnection());
        $ticket_id = isset($_GET['ticket_id']) ? (int)$_GET['ticket_id'] : (count($tickets) ? (int)$tickets[0]['id'] : 0);
        $items_ticket = $ticket_id ? $itemTicketModel->listarPorTicket($ticket_id) : [];

    include_once __DIR__ . '/../Views/Tecnicos/MisRepuestos.php';
    }

    public function SolicitarRepuesto() {
        $user = Auth::user();
        if (!$user || $user['role'] !== 'Tecnico') {
            header('Location: /ProyectoPandora/Public/index.php?route=Auth/Login');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /ProyectoPandora/Public/index.php?route=Tecnico/MisRepuestos&error=1');
            exit;
        }
    $ticket_id = (int)($_POST['ticket_id'] ?? 0);
        $inventario_id = (int)($_POST['inventario_id'] ?? 0);
        $cantidad = (int)($_POST['cantidad'] ?? 0);
    $valor_unitario = 0.0; // se obtiene del inventario para evitar manipulación en cliente
        if ($ticket_id <= 0 || $inventario_id <= 0 || $cantidad <= 0) {
            header('Location: /ProyectoPandora/Public/index.php?route=Tecnico/MisRepuestos&error=1');
            exit;
        }

        $inventarioModel = new InventarioModel($this->db->getConnection());
        $itemTicketModel = new ItemTicketModel($this->db->getConnection());
        $ticketModel = new Ticket($this->db->getConnection());

        // Obtener valor_unitario y supervisor_id desde el servidor
        // Validar que el ticket pertenece al técnico logueado
        $tickets = (new Ticket($this->db->getConnection()))->getTicketsByTecnicoId($user['id']);
        $ticketIds = array_map(function($t){ return (int)$t['id']; }, $tickets);
        if (!in_array($ticket_id, $ticketIds, true)) {
            header('Location: /ProyectoPandora/Public/index.php?route=Tecnico/MisRepuestos&error=ticket');
            exit;
        }

        $inv = $inventarioModel->obtenerPorId($inventario_id);
        if (!$inv) {
            header('Location: /ProyectoPandora/Public/index.php?route=Tecnico/MisRepuestos&error=inventario');
            exit;
        }
        $valor_unitario = (float)$inv['valor_unitario'];
        $supervisor_id = (int)($ticketModel->getSupervisorId($ticket_id) ?? 0);
        if ($supervisor_id <= 0) {
            // Si el ticket no tiene supervisor, registrar null y ajustar modelo para permitir NULL o usar 0 si FK lo permite
            $supervisor_id = 0;
        }

        // Validar y reducir stock
        if (!$inventarioModel->reducirStock($inventario_id, $cantidad)) {
            header('Location: /ProyectoPandora/Public/index.php?route=Tecnico/MisRepuestos&error=stock');
            exit;
        }

        // Obtener tecnico_id real (tabla tecnicos) desde users.id
        $tecnico_id = $this->obtenerTecnicoIdPorUserId($user['id']);
        if (!$tecnico_id) {
            header('Location: /ProyectoPandora/Public/index.php?route=Tecnico/MisRepuestos&error=tecnico');
            exit;
        }

    $valor_total = $cantidad * $valor_unitario;
    $ok = $itemTicketModel->crear($ticket_id, $inventario_id, $tecnico_id, $supervisor_id, $cantidad, $valor_total);
        if ($ok) {
            $this->historial->agregarAccion(
                'Solicitud de repuesto',
                "Técnico {$user['name']} solicitó {$cantidad} und(s) del inventario ID {$inventario_id} para ticket {$ticket_id} (total $valor_total)."
            );
            header('Location: /ProyectoPandora/Public/index.php?route=Tecnico/MisRepuestos&success=1&ticket_id=' . $ticket_id);
            exit;
        }
        header('Location: /ProyectoPandora/Public/index.php?route=Tecnico/MisRepuestos&error=1');
        exit;
    }

    public function MisStats() {
        $user = Auth::user();
        if (!$user || $user['role'] !== 'Tecnico') {
            header('Location: /ProyectoPandora/Public/index.php?route=Auth/Login');
            exit;
        }
        $conn = $this->db->getConnection();
        // Obtener tecnico_id
        $tecnico_id = $this->obtenerTecnicoIdPorUserId($user['id']);
        $statsModel = new TecnicoStatsModel($conn);
        $ratingModel = new RatingModel($conn);
        $ticketModel = new Ticket($conn);
        $stats = $statsModel->getByTecnico($tecnico_id) ?: ['labor_min'=>0,'labor_max'=>0];
        list($avg, $count) = $ratingModel->getAvgForTecnico($tecnico_id);

        // Contadores
        $res = $conn->query("SELECT 
            SUM(CASE WHEN fecha_cierre IS NOT NULL THEN 1 ELSE 0 END) AS finalizados,
            SUM(CASE WHEN fecha_cierre IS NULL THEN 1 ELSE 0 END) AS activos
            FROM tickets t INNER JOIN tecnicos tc ON t.tecnico_id = tc.id WHERE tc.user_id = " . (int)$user['id']);
        $counters = $res ? $res->fetch_assoc() : ['finalizados'=>0,'activos'=>0];

        include_once __DIR__ . '/../Views/Tecnicos/MisStats.php';
    }

    public function ActualizarStats() {
        $user = Auth::user();
        if (!$user) {
            header('Location: /ProyectoPandora/Public/index.php?route=Auth/Login');
            exit;
        }
        $conn = $this->db->getConnection();
        $tecnico_id = $this->obtenerTecnicoIdPorUserId($user['id']);

        if (isset($_POST['ticket_id']) && isset($_POST['labor_amount'])) {
            // Guardar mano de obra por ticket
            $ticket_id = (int)$_POST['ticket_id'];
            $labor_amount = max(0, (float)$_POST['labor_amount']);
            $laborModel = new TicketLaborModel($conn);
            $laborModel->upsert($ticket_id, $tecnico_id ?: 0, $labor_amount);
            header('Location: ' . ($_SESSION['prev_url'] ?? '/ProyectoPandora/Public/index.php?route=Supervisor/Presupuestos'));
            exit;
        }

        if (isset($_POST['labor_min']) || isset($_POST['labor_max'])) {
            $min = max(0, (float)($_POST['labor_min'] ?? 0));
            $max = max($min, (float)($_POST['labor_max'] ?? 0));
            $statsModel = new TecnicoStatsModel($conn);
            $statsModel->upsert($tecnico_id, $min, $max);
            header('Location: /ProyectoPandora/Public/index.php?route=Tecnico/MisStats&ok=1');
            exit;
        }

        header('Location: /ProyectoPandora/Public/index.php?route=Default/Index');
    }

    private function obtenerTecnicoIdPorUserId($user_id) {
        $stmt = $this->db->getConnection()->prepare("SELECT id FROM tecnicos WHERE user_id = ? LIMIT 1");
        if (!$stmt) return null;
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        return $res['id'] ?? null;
    }
}