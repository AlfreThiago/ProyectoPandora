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

        $ok = $ticketModel->asignarTecnico((int)$ticket_id, (int)$tecnico_id);
        if ($ok) {
            $userModel->setTecnicoEstado((int)$tecnico_id, 'Ocupado');
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