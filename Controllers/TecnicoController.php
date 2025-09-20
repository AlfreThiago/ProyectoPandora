<?php    
require_once __DIR__ . '/../Core/Auth.php';
require_once __DIR__ . '/../Models/Ticket.php';
require_once __DIR__ . '/../Models/Inventario.php';
require_once __DIR__ . '/../Models/ItemTicket.php';
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
        include_once __DIR__ . '/../Views/Tecnicos/PanelTecnico.php';
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

    private function obtenerTecnicoIdPorUserId($user_id) {
        $stmt = $this->db->getConnection()->prepare("SELECT id FROM tecnicos WHERE user_id = ? LIMIT 1");
        if (!$stmt) return null;
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        return $res['id'] ?? null;
    }
}