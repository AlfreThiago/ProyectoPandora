<?php
require_once __DIR__ . '/../Core/Auth.php';
require_once __DIR__ . '/../Models/Ticket.php';
require_once __DIR__ . '/../Models/Device.php';
require_once __DIR__ . '/../Core/Database.php';

class DefaultController
{

    public function index()
    {
        // Auto-refresh de la página cada 30s sin usar JSON/AJAX
        header('Refresh: 30');
        $user = Auth::user();
        $stats = $this->computeHomeStats($user);
        include_once __DIR__ . '/../Views/AllUsers/Home.php';
    }

    // Endpoint JSON removido por requerimiento: solo PHP renderizado en servidor

    private function computeHomeStats(?array $user): array
    {
        $stats = [
            'activeTickets'    => 0,
            'avgRating'        => null,
            'lastUpdateIso'    => null,
            'lastUpdateHuman'  => '—',
        ];
        try {
            $db = new \Database();
            $db->connectDatabase();
            $conn = $db->getConnection();

            $role = $user['role'] ?? 'Invitado';
            $userId = isset($user['id']) ? (int)$user['id'] : null;

            // Reutilizar modelo Ticket para obtener listados y contar activos por estado
            $ticketModel = new \Ticket($conn);
            $inactivos = ['finalizado','cerrado','cancelado'];
            $activos = 0;
            if ($role === 'Cliente' && $userId) {
                $lista = $ticketModel->getTicketsByUserId($userId) ?: [];
                foreach ($lista as $row) {
                    $est = strtolower(trim($row['estado'] ?? ''));
                    if (!in_array($est, $inactivos, true)) $activos++;
                }
            } elseif ($role === 'Tecnico' && $userId) {
                $lista = $ticketModel->getTicketsByTecnicoId($userId) ?: [];
                foreach ($lista as $row) {
                    $est = strtolower(trim($row['estado'] ?? ''));
                    if (!in_array($est, $inactivos, true)) $activos++;
                }
            } else {
                $lista = $ticketModel->getAllTickets() ?: [];
                foreach ($lista as $row) {
                    $est = strtolower(trim($row['estado'] ?? ''));
                    if (!in_array($est, $inactivos, true)) $activos++;
                }
            }
            $stats['activeTickets'] = $activos;

            // Promedio de calificaciones
            @require_once __DIR__ . '/../Models/Rating.php';
            if (class_exists('RatingModel')) {
                new \RatingModel($conn); // ensureTable
            }
            if ($q = $conn->query("SELECT ROUND(AVG(stars), 1) AS avg_s FROM ticket_ratings")) {
                $row = $q->fetch_assoc();
                $stats['avgRating'] = $row && $row['avg_s'] !== null ? (float)$row['avg_s'] : null;
            }

            // Última actualización
            $lastIso = null;
            if ($role === 'Cliente' && $userId) {
                $sqlH = "SELECT MAX(h.created_at) AS last
                         FROM ticket_estado_historial h
                         INNER JOIN tickets t ON h.ticket_id = t.id
                         INNER JOIN clientes c ON t.cliente_id = c.id
                         WHERE c.user_id = ?";
                if ($st = $conn->prepare($sqlH)) {
                    $st->bind_param('i', $userId);
                    $st->execute();
                    $lastIso = $st->get_result()->fetch_assoc()['last'] ?? null;
                }
                if (!$lastIso) {
                    $sqlF = "SELECT MAX(t.fecha_creacion) AS last
                             FROM tickets t
                             INNER JOIN clientes c ON t.cliente_id = c.id
                             WHERE c.user_id = ?";
                    if ($st2 = $conn->prepare($sqlF)) {
                        $st2->bind_param('i', $userId);
                        $st2->execute();
                        $lastIso = $st2->get_result()->fetch_assoc()['last'] ?? null;
                    }
                }
            } elseif ($role === 'Tecnico' && $userId) {
                $sqlH = "SELECT MAX(h.created_at) AS last
                         FROM ticket_estado_historial h
                         INNER JOIN tickets t ON h.ticket_id = t.id
                         INNER JOIN tecnicos tc ON t.tecnico_id = tc.id
                         WHERE tc.user_id = ?";
                if ($st = $conn->prepare($sqlH)) {
                    $st->bind_param('i', $userId);
                    $st->execute();
                    $lastIso = $st->get_result()->fetch_assoc()['last'] ?? null;
                }
                if (!$lastIso) {
                    $sqlF = "SELECT MAX(t.fecha_creacion) AS last
                             FROM tickets t
                             INNER JOIN tecnicos tc ON t.tecnico_id = tc.id
                             WHERE tc.user_id = ?";
                    if ($st2 = $conn->prepare($sqlF)) {
                        $st2->bind_param('i', $userId);
                        $st2->execute();
                        $lastIso = $st2->get_result()->fetch_assoc()['last'] ?? null;
                    }
                }
            } else {
                if ($q = $conn->query("SELECT MAX(created_at) AS last FROM ticket_estado_historial")) {
                    $lastIso = $q->fetch_assoc()['last'] ?? null;
                }
                if (!$lastIso) {
                    if ($q2 = $conn->query("SELECT MAX(fecha_creacion) AS last FROM tickets")) {
                        $lastIso = $q2->fetch_assoc()['last'] ?? null;
                    }
                }
            }

            $stats['lastUpdateIso'] = $lastIso;
            if ($lastIso) {
                $ts = strtotime($lastIso);
                if ($ts !== false) {
                    $diff = time() - $ts;
                    if ($diff < 60) {
                        $stats['lastUpdateHuman'] = 'hace ' . $diff . 's';
                    } elseif ($diff < 3600) {
                        $stats['lastUpdateHuman'] = 'hace ' . floor($diff / 60) . 'm';
                    } elseif ($diff < 86400) {
                        $stats['lastUpdateHuman'] = 'hace ' . floor($diff / 3600) . 'h';
                        } else {
                        $stats['lastUpdateHuman'] = date('d/m/Y H:i', $ts);
                    }
                }
            }
    } catch (\Throwable $e) {
            // error_log('[Home stats] ' . $e->getMessage());
        }
        return $stats;
    }
    public function index2() {
        $user = Auth::user();
        include_once __DIR__ . '/../Views/AllUsers/Guia.php';
    }  
    public function perfil()
    {
        $user = $_SESSION['user'] ?? [];
        $userName = $user['name'] ?? 'Usuario';
        $userEmail = $user['email'] ?? '';
    
    $userImg = $user['img_perfil'] ?? '/ProyectoPandora/Public/img/imgPerfil/default.png';
        $rol = $user['role'] ?? '';
        $userId = $user['id'] ?? null;

        $db = new \Database();
        $db->connectDatabase();
        $ticketModel = new \Ticket($db->getConnection());
        $deviceModel = new \DeviceModel($db->getConnection());

    $cantTickets = 0;
    $cantDevices = 0;
    $tecnicoDisponibilidad = null;

        if ($rol === 'Cliente' && $userId) {
            $tickets = $ticketModel->getTicketsByUserId($userId);
            $cantTickets = is_array($tickets) ? count($tickets) : 0;
            $devices = $deviceModel->getDevicesByUserId($userId);
            $cantDevices = is_array($devices) ? count($devices) : 0;
        } elseif ($rol === 'Tecnico' && $userId) {
            $tickets = $ticketModel->getTicketsByTecnicoId($userId);
            $cantTickets = is_array($tickets) ? count($tickets) : 0;
            
            $stmtDisp = $db->getConnection()->prepare("SELECT disponibilidad FROM tecnicos WHERE user_id = ? LIMIT 1");
            if ($stmtDisp) {
                $stmtDisp->bind_param("i", $userId);
                $stmtDisp->execute();
                $resDisp = $stmtDisp->get_result()->fetch_assoc();
                $tecnicoDisponibilidad = $resDisp['disponibilidad'] ?? null;
            }
        } else {
            $tickets = $ticketModel->getAllTickets();
            $cantTickets = is_array($tickets) ? count($tickets) : 0;
            $devices = $deviceModel->getAllDevices();
            $cantDevices = is_array($devices) ? count($devices) : 0;
        }

        
        $panelUrl = '/ProyectoPandora/Public/index.php?route=Default/Index';
        if ($rol === 'Administrador') {
            $panelUrl = '/ProyectoPandora/Public/index.php?route=Admin/ListarUsers';
        } elseif ($rol === 'Tecnico') {
            $panelUrl = '/ProyectoPandora/Public/index.php?route=Tecnico/MisReparaciones';
        } elseif ($rol === 'Supervisor') {
            $panelUrl = '/ProyectoPandora/Public/index.php?route=Supervisor/Asignar';
        } elseif ($rol === 'Cliente') {
            $panelUrl = '/ProyectoPandora/Public/index.php?route=Cliente/MisDevice';
        }

        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $user['id'] ?? null;
            $newName = $_POST['name'] ?? '';
            $newEmail = $_POST['email'] ?? '';
            $imgPerfil = $user['img_perfil'] ?? '/ProyectoPandora/Public/img/imgPerfil/default.png';

            
            if (isset($_FILES['img_perfil']) && $_FILES['img_perfil']['error'] === UPLOAD_ERR_OK) {
                $imgTmp = $_FILES['img_perfil']['tmp_name'];
                $origName = $_FILES['img_perfil']['name'] ?? 'avatar.png';
                
                $safeName = preg_replace('/[^A-Za-z0-9_\.-]/', '_', $origName);
                $imgName = uniqid('perfil_') . '_' . $safeName;
                $webDir = '/ProyectoPandora/Public/img/imgPerfil';
                $fsDir = rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . $webDir;
                
                if (!is_dir($fsDir)) {
                    @mkdir($fsDir, 0775, true);
                }
                $imgPath = $webDir . '/' . $imgName;
                $destFs = rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . $imgPath;
                if (@move_uploaded_file($imgTmp, $destFs)) {
                    $imgPerfil = $imgPath;
                }
            }

            
            $userModel = new \UserModel($db->getConnection());
            $userModel->actualizarPerfil($userId, $newName, $newEmail, $imgPerfil);

            
            if ($rol === 'Tecnico') {
                $nuevaDisp = $_POST['disponibilidad'] ?? null;
                if ($nuevaDisp === 'Disponible' || $nuevaDisp === 'Ocupado') {
                    
                    $stmtUpd = $db->getConnection()->prepare("UPDATE tecnicos SET disponibilidad = ? WHERE user_id = ?");
                    if ($stmtUpd) {
                        $stmtUpd->bind_param("si", $nuevaDisp, $userId);
                        $stmtUpd->execute();
                        $tecnicoDisponibilidad = $nuevaDisp;
                    }
                }
            }

            
            $_SESSION['user']['name'] = $newName;
            $_SESSION['user']['email'] = $newEmail;
            $_SESSION['user']['img_perfil'] = $imgPerfil;
            

            
            header('Location: /ProyectoPandora/Public/index.php?route=Default/Perfil');
            exit;
        }

        
    include_once __DIR__ . '/../Views/AllUsers/Perfil.php';
    }
}
