<?php
require_once __DIR__ . '/../Core/Auth.php';
require_once __DIR__ . '/../Models/Ticket.php';
require_once __DIR__ . '/../Models/Device.php';
require_once __DIR__ . '/../Core/Database.php';

class DefaultController
{

    public function index()
    {
        $user = Auth::user();
        include_once __DIR__ . '/../Views/AllUsers/Home.php';
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
