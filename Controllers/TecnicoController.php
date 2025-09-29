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

        
        $tickets = $ticketModel->getTicketsByTecnicoId($user['id']);

        
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
    $valor_unitario = 0.0; 
        if ($ticket_id <= 0 || $inventario_id <= 0 || $cantidad <= 0) {
            header('Location: /ProyectoPandora/Public/index.php?route=Tecnico/MisRepuestos&error=1');
            exit;
        }

        $inventarioModel = new InventarioModel($this->db->getConnection());
        $itemTicketModel = new ItemTicketModel($this->db->getConnection());
        $ticketModel = new Ticket($this->db->getConnection());

        
        
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
            
            $supervisor_id = 0;
        }

        
        if (!$inventarioModel->reducirStock($inventario_id, $cantidad)) {
            header('Location: /ProyectoPandora/Public/index.php?route=Tecnico/MisRepuestos&error=stock');
            exit;
        }

        
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
            
            $laborModel2 = new TicketLaborModel($this->db->getConnection());
            $labor = $laborModel2->getByTicket($ticket_id);
            if ($labor && (float)($labor['labor_amount'] ?? 0) > 0) {
                require_once __DIR__ . '/../Models/EstadoTicket.php';
                $em2 = new EstadoTicketModel($this->db->getConnection());
                $estados = $em2->getAllEstados();
                $esperaId = 0; foreach ($estados as $e) { if (strcasecmp($e['name'],'En espera')===0) { $esperaId = (int)$e['id']; break; } }
                if ($esperaId) {
                    $this->db->getConnection()->query("UPDATE tickets SET estado_id = ".$esperaId." WHERE id = ".$ticket_id);
                    require_once __DIR__ . '/../Models/TicketEstadoHistorial.php';
                    $hist2 = new TicketEstadoHistorialModel($this->db->getConnection());
                    $hist2->add($ticket_id, $esperaId, (int)$user['id'], 'Tecnico', 'Repuestos listos + mano de obra definida: presupuesto listo para publicar');
                }
            }
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
        
        $tecnico_id = $this->obtenerTecnicoIdPorUserId($user['id']);
        $statsModel = new TecnicoStatsModel($conn);
        $ratingModel = new RatingModel($conn);
        $ticketModel = new Ticket($conn);
        $stats = $statsModel->getByTecnico($tecnico_id) ?: ['labor_min'=>0,'labor_max'=>0];
        list($avg, $count) = $ratingModel->getAvgForTecnico($tecnico_id);

        
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
            
            $ticket_id = (int)$_POST['ticket_id'];
            $labor_amount = max(0, (float)$_POST['labor_amount']);
            $role = $user['role'] ?? '';
            $isTecnico = ($role === 'Tecnico');
            $isSupervisor = ($role === 'Supervisor');
            $ticketTecnicoId = null;
            
            $stmtT = $conn->prepare("SELECT t.tecnico_id, e.name AS estado FROM tickets t INNER JOIN estados_tickets e ON e.id = t.estado_id WHERE t.id = ? LIMIT 1");
            if ($stmtT) { $stmtT->bind_param("i", $ticket_id); $stmtT->execute(); $rT = $stmtT->get_result()->fetch_assoc(); $ticketTecnicoId = $rT['tecnico_id'] ?? null; }
            $estadoActualNombre = strtolower(trim($rT["estado"] ?? ''));

            if ($isTecnico) {
                
                if (!$tecnico_id) {
                    header('Location: /ProyectoPandora/Public/index.php?route=Tecnico/MisStats&error=tecnico');
                    exit;
                }
                if ((int)($ticketTecnicoId ?? 0) <= 0) {
                    header('Location: /ProyectoPandora/Public/index.php?route=Tecnico/MisStats&error=ticket');
                    exit;
                }
                $stmtChk = $conn->prepare("SELECT COUNT(*) c FROM tecnicos tc WHERE tc.id = ? AND tc.user_id = ?");
                if ($stmtChk) {
                    $stmtChk->bind_param("ii", $ticketTecnicoId, $user['id']);
                    $stmtChk->execute();
                    $row = $stmtChk->get_result()->fetch_assoc();
                    if (((int)($row['c'] ?? 0)) === 0) {
                        header('Location: /ProyectoPandora/Public/index.php?route=Tecnico/MisStats&error=ticket');
                        exit;
                    }
                }
                
                if (!in_array($estadoActualNombre, ['diagnóstico','diagnostico'], true)) {
                    header('Location: /ProyectoPandora/Public/index.php?route=Ticket/Ver&id='.(int)$ticket_id.'&error=labor_estado');
                    exit;
                }
                
                $statsModel = new TecnicoStatsModel($conn);
                $statsRow = $statsModel->getByTecnico((int)$ticketTecnicoId);
                if ($statsRow) {
                    $min = (float)($statsRow['labor_min'] ?? 0);
                    $max = (float)($statsRow['labor_max'] ?? 0);
                    if ($max > 0 && ($labor_amount < $min || $labor_amount > $max)) {
                        header('Location: ' . ($_SESSION['prev_url'] ?? '/ProyectoPandora/Public/index.php?route=Tecnico/MisStats') . '&error=labor_range');
                        exit;
                    }
                }
                $saveTecnicoId = (int)$ticketTecnicoId;
            } elseif ($isSupervisor) {
                
                if ((int)($ticketTecnicoId ?? 0) <= 0) {
                    header('Location: /ProyectoPandora/Public/index.php?route=Supervisor/Presupuestos&error=sin_tecnico');
                    exit;
                }
                
                if (!in_array($estadoActualNombre, ['diagnóstico','diagnostico'], true)) {
                    header('Location: /ProyectoPandora/Public/index.php?route=Supervisor/Presupuestos&error=labor_estado');
                    exit;
                }
                $saveTecnicoId = (int)$ticketTecnicoId;
            } else {
                header('Location: /ProyectoPandora/Public/index.php?route=Auth/Login');
                exit;
            }
            $laborModel = new TicketLaborModel($conn);
            $existing = $laborModel->getByTicket($ticket_id);
            if ($existing && (float)($existing['labor_amount'] ?? 0) > 0) {
                
                if ($isSupervisor) {
                    header('Location: /ProyectoPandora/Public/index.php?route=Supervisor/Presupuestos&error=labor_locked');
                } else {
                    header('Location: /ProyectoPandora/Public/index.php?route=Ticket/Ver&id='.(int)$ticket_id.'&error=labor_locked');
                }
                exit;
            }
            $laborModel->upsert($ticket_id, (int)$saveTecnicoId, $labor_amount);
            
            require_once __DIR__ . '/../Models/ItemTicket.php';
            $itemModelX = new ItemTicketModel($conn);
            $itemsX = $itemModelX->listarPorTicket($ticket_id);
            if (!empty($itemsX) && $labor_amount > 0) {
                
                require_once __DIR__ . '/../Models/EstadoTicket.php';
                $em = new EstadoTicketModel($conn);
                $stmtEstados = $conn->query("SELECT id, name FROM estados_tickets");
                $enEsperaId = 0;
                if ($stmtEstados) { while($r=$stmtEstados->fetch_assoc()){ if (strcasecmp($r['name'],'En espera')===0) { $enEsperaId=(int)$r['id']; break; } } }
                if ($enEsperaId) {
                    $conn->query("UPDATE tickets SET estado_id = ".$enEsperaId." WHERE id = ".$ticket_id);
                    
                    require_once __DIR__ . '/../Models/TicketEstadoHistorial.php';
                    $histM = new TicketEstadoHistorialModel($conn);
                    $histM->add($ticket_id, $enEsperaId, (int)($user['id']), $user['role'], 'Presupuesto preparado: items y mano de obra listos');
                }
            }
            
            if ($isSupervisor) {
                header('Location: /ProyectoPandora/Public/index.php?route=Supervisor/Presupuestos&ok=labor');
            } else {
                header('Location: /ProyectoPandora/Public/index.php?route=Ticket/Ver&id='.(int)$ticket_id.'&ok=labor');
            }
            exit;
        }

        if (isset($_POST['labor_min']) || isset($_POST['labor_max'])) {
            
            if (($user['role'] ?? '') !== 'Tecnico') {
                header('Location: /ProyectoPandora/Public/index.php?route=Default/Index&error=permiso');
                exit;
            }
            if (!$tecnico_id) {
                header('Location: /ProyectoPandora/Public/index.php?route=Tecnico/MisStats&error=tecnico');
                exit;
            }
            $min = max(0, (float)($_POST['labor_min'] ?? 0));
            $max = max($min, (float)($_POST['labor_max'] ?? 0));
            $statsModel = new TecnicoStatsModel($conn);
            $statsModel->upsert((int)$tecnico_id, $min, $max);
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