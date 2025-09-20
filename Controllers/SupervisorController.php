<?php
require_once __DIR__ . '/../Core/Auth.php';
require_once __DIR__ . '/../Core/Database.php';
require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../Models/Ticket.php';
require_once __DIR__ . '/../Models/Inventario.php';
require_once __DIR__ . '/../Models/Category.php';

class SupervisorController {
    public function PanelSupervisor() {
        require_once __DIR__ . '/../Views/Supervisor/PanelSupervisor.php';
    }

    public function Asignar() {
        Auth::checkRole(['Supervisor', 'Administrador']);

        $db = new Database();
        $db->connectDatabase();
        $userModel = new UserModel($db->getConnection());
        $ticketModel = new Ticket($db->getConnection());

        $tecnicos = $userModel->getAllTecnicos();
        $ticketsSinTecnico = $ticketModel->getTicketsSinTecnico();

        include_once __DIR__ . '/../Views/Supervisor/Asignar.php';
    }

    public function AsignarTecnico() {
        Auth::checkRole(['Supervisor', 'Administrador']);

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

        // Verificar que el ticket no tenga técnico asignado actualmente
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

        // Evitar asignar un ticket que ya tenga técnico
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

        $ok = $ticketModel->asignarTecnico((int)$ticket_id, (int)$tecnico_id);
        if ($ok) {
            // Asociar supervisor actual al ticket si no está seteado
            $supervisorUserId = $_SESSION['user']['id'] ?? null;
            if ($supervisorUserId) {
                // Obtener supervisor_id real desde user_id
                $conn = $db->getConnection();
                $stmt = $conn->prepare("SELECT id FROM supervisores WHERE user_id = ? LIMIT 1");
                if ($stmt) {
                    $stmt->bind_param("i", $supervisorUserId);
                    $stmt->execute();
                    $sup = $stmt->get_result()->fetch_assoc();
                    if ($sup && isset($sup['id'])) {
                        $ticketModel->asignarSupervisor((int)$ticket_id, (int)$sup['id']);
                    }
                }
            }
            header('Location: /ProyectoPandora/Public/index.php?route=Supervisor/Asignar&success=1');
        } else {
            header('Location: /ProyectoPandora/Public/index.php?route=Supervisor/Asignar&error=No se pudo asignar');
        }
        exit;
    }

    public function GestionInventario() {
        Auth::checkRole(['Supervisor', 'Administrador']);

        $db = new Database();
        $db->connectDatabase();
        $inventarioModel = new InventarioModel($db->getConnection());
        $categoryModel = new CategoryModel($db->getConnection());

        $items = $inventarioModel->listar();
        $categorias = $inventarioModel->listarCategorias();

        include_once __DIR__ . '/../Views/Supervisor/GestionInventario.php';
    }
}