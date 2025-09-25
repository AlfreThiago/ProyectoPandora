<?php
require_once __DIR__ . '/../Core/Auth.php';
require_once __DIR__ . '/../Core/Database.php';
require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../Models/Ticket.php';
require_once __DIR__ . '/../Models/Inventario.php';
require_once __DIR__ . '/../Models/Category.php';
require_once __DIR__ . '/../Models/ItemTicket.php';
require_once __DIR__ . '/../Models/TicketLabor.php';
require_once __DIR__ . '/../Models/Rating.php';

class SupervisorController {
    public function PanelSupervisor() {
        Auth::checkRole(['Supervisor']);
        header('Location: /ProyectoPandora/Public/index.php?route=Supervisor/Asignar');
        exit;
    }

    public function Asignar() {
        Auth::checkRole(['Supervisor']);

        $db = new Database();
        $db->connectDatabase();
        $userModel = new UserModel($db->getConnection());
        $ticketModel = new Ticket($db->getConnection());
        $ratingModel = new RatingModel($db->getConnection());

        $tecnicos = $userModel->getAllTecnicos();
        $ticketsSinTecnico = $ticketModel->getTicketsSinTecnico();

        
        foreach ($tecnicos as &$tec) {
            $tecId = (int)($tec['id'] ?? 0);
            list($avg, $count) = $ratingModel->getAvgForTecnico($tecId);
            $tec['rating_avg'] = $avg ? (float)$avg : 0.0;
            $tec['rating_count'] = (int)$count;
        }
        unset($tec);
        usort($tecnicos, function($a,$b){
            $ra = $a['rating_avg'] ?? 0; $rb = $b['rating_avg'] ?? 0;
            if ($rb <=> $ra) return ($rb <=> $ra); 
            
            return (int)($a['tickets_activos'] ?? 0) <=> (int)($b['tickets_activos'] ?? 0);
        });

        include_once __DIR__ . '/../Views/Supervisor/Asignar.php';
    }

    public function AsignarTecnico() {
        Auth::checkRole(['Supervisor']);

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /ProyectoPandora/Public/index.php?route=Supervisor/Asignar');
            exit;
        }

        $ticket_id = $_POST['ticket_id'] ?? null;
        $tecnico_id = $_POST['tecnico_id'] ?? null;
        if (!$ticket_id || !$tecnico_id) {
            header('Location: /ProyectoPandora/Public/index.php?route=Supervisor/Asignar&error=Datos incompletos');
            exit;
        }

        $db = new Database();
        $db->connectDatabase();
        $ticketModel = new Ticket($db->getConnection());
        $userModel = new UserModel($db->getConnection());

        
        $conn = $db->getConnection();
        $stmtChk = $conn->prepare("SELECT tecnico_id FROM tickets WHERE id = ? LIMIT 1");
        if ($stmtChk) {
            $stmtChk->bind_param("i", $ticket_id);
            $stmtChk->execute();
            $rowChk = $stmtChk->get_result()->fetch_assoc();
            if (!empty($rowChk['tecnico_id'])) {
                header('Location: /ProyectoPandora/Public/index.php?route=Supervisor/Asignar&error=El ticket ya tiene un técnico asignado');
                exit;
            }
        }

        
        $conn = $db->getConnection();
        $stmtChk = $conn->prepare("SELECT tecnico_id FROM tickets WHERE id = ? LIMIT 1");
        if ($stmtChk) {
            $stmtChk->bind_param("i", $ticket_id);
            $stmtChk->execute();
            $row = $stmtChk->get_result()->fetch_assoc();
            if (!empty($row['tecnico_id'])) {
                header('Location: /ProyectoPandora/Public/index.php?route=Supervisor/Asignar&error=El ticket ya tiene un técnico asignado');
                exit;
            }
        }

        
        $conn = $db->getConnection();
        
        $ratingAvg = 0; $ratingCount = 0; $starsRounded = 0;
        $ratingRes = $conn->query("SELECT AVG(stars) avg_stars, COUNT(*) cnt FROM ticket_ratings WHERE tecnico_id = ".(int)$tecnico_id);
        if ($ratingRes) { $r = $ratingRes->fetch_assoc(); $ratingAvg = (float)($r['avg_stars'] ?? 0); $ratingCount = (int)($r['cnt'] ?? 0); }
        $starsRounded = (int)round($ratingAvg ?: 0);
        
        $limits = [1=>3, 2=>5, 3=>10, 4=>15, 5=>PHP_INT_MAX];
        $limit = $limits[$starsRounded ?: 0] ?? 5; 
        
        $resAct = $conn->query("SELECT COUNT(*) c FROM tickets WHERE tecnico_id = ".(int)$tecnico_id." AND fecha_cierre IS NULL");
        $activos = $resAct ? (int)$resAct->fetch_assoc()['c'] : 0;
        if ($activos >= $limit) {
            header('Location: /ProyectoPandora/Public/index.php?route=Supervisor/Asignar&error=Limite de tickets activos alcanzado segun honor');
            exit;
        }

        $ok = $ticketModel->asignarTecnico((int)$ticket_id, (int)$tecnico_id);
        if ($ok) {
            
            $supervisorUserId = $_SESSION['user']['id'] ?? null;
            if ($supervisorUserId) {
                
                $conn = $db->getConnection();
                $stmt = $conn->prepare("SELECT id FROM supervisores WHERE user_id = ? LIMIT 1");
            
            $ratingModel = new RatingModel($db->getConnection());
            list($avg, $rcount) = $ratingModel->getAvgForTecnico((int)$tecnico_id);
            $stars = $avg ? (int)round((float)$avg) : 3; 
            $limit = null; 
            if ($stars <= 1) $limit = 3; elseif ($stars === 2) $limit = 5; elseif ($stars === 3) $limit = 10; elseif ($stars === 4) $limit = 15; else $limit = null; 

            
            $stmtCnt = $conn->prepare("SELECT COUNT(*) AS c FROM tickets WHERE tecnico_id = ? AND fecha_cierre IS NULL");
            $stmtCnt->bind_param("i", $tecnico_id);
            $stmtCnt->execute();
            $activos = (int)($stmtCnt->get_result()->fetch_assoc()['c'] ?? 0);

            if ($limit !== null && $activos >= $limit) {
                
                $userModel->setTecnicoEstado((int)$tecnico_id, 'Ocupado');
                header('Location: /ProyectoPandora/Public/index.php?route=Supervisor/Asignar&error=Limite de tickets activos alcanzado para este técnico');
                exit;
            }
                if ($stmt) {
                    $stmt->bind_param("i", $supervisorUserId);
                    $stmt->execute();
                    $sup = $stmt->get_result()->fetch_assoc();
                    if ($sup && isset($sup['id'])) {
                        $ticketModel->asignarSupervisor((int)$ticket_id, (int)$sup['id']);
                    }
                }
            }
            
            if ($starsRounded < 5) {
                $resAct = $conn->query("SELECT COUNT(*) c FROM tickets WHERE tecnico_id = ".(int)$tecnico_id." AND fecha_cierre IS NULL");
                $activos = $resAct ? (int)$resAct->fetch_assoc()['c'] : 0;
                if ($activos >= $limit) {
                    $conn->query("UPDATE tecnicos SET disponibilidad = 'Ocupado' WHERE id = ".(int)$tecnico_id);
                }
            }

                
                if ($limit !== null) {
                    $activos += 1;
                    if ($activos >= $limit) {
                        $userModel->setTecnicoEstado((int)$tecnico_id, 'Ocupado');
                    }
                }
            header('Location: /ProyectoPandora/Public/index.php?route=Supervisor/Asignar&success=1');
        } else {
            header('Location: /ProyectoPandora/Public/index.php?route=Supervisor/Asignar&error=No se pudo asignar');
        }
        exit;
    }

    public function GestionInventario() {
        Auth::checkRole(['Supervisor']);

        $db = new Database();
        $db->connectDatabase();
        $inventarioModel = new InventarioModel($db->getConnection());
        $categoryModel = new CategoryModel($db->getConnection());

        $items = $inventarioModel->listar();
        $categorias = $inventarioModel->listarCategorias();

        include_once __DIR__ . '/../Views/Supervisor/GestionInventario.php';
    }

    public function Presupuestos() {
        Auth::checkRole(['Supervisor']);

        $db = new Database();
        $db->connectDatabase();
        $ticketModel = new Ticket($db->getConnection());
        $itemTicketModel = new ItemTicketModel($db->getConnection());
        $laborModel = new TicketLaborModel($db->getConnection());

        
        $ticket_id = isset($_GET['ticket_id']) ? (int)$_GET['ticket_id'] : 0;
        $tickets = $ticket_id ? [$ticketModel->ver($ticket_id)] : $ticketModel->getAllTickets();
        if (!$ticket_id) {
            
            $tickets = is_array($tickets) && isset($tickets[0]) ? $tickets : $tickets;
        }

        
        if ($ticket_id && $tickets && isset($tickets['id'])) {
            $tickets = [$tickets];
        }

        $presupuestos = [];
        foreach ($tickets as $t) {
            if (!$t || !isset($t['id'])) continue;
            $tid = (int)$t['id'];
            $items = $itemTicketModel->listarPorTicket($tid);
            $subtotal_items = 0.0;
            foreach ($items as $it) {
                
                $subtotal_items += (float)$it['valor_total'];
            }
            $labor = $laborModel->getByTicket($tid);
            $mano_obra = $labor ? (float)$labor['labor_amount'] : 0.0;
            $total = $subtotal_items + $mano_obra;
            $presupuestos[] = [
                'ticket' => $t,
                'items' => $items,
                'subtotal_items' => $subtotal_items,
                'mano_obra' => $mano_obra,
                'total' => $total,
            ];
        }

        include_once __DIR__ . '/../Views/Supervisor/Presupuestos.php';
    }
}