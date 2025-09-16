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
        $userImg = $user['img_perfil'] ?? '/ProyectoPandora/Public/img/Innovasys.png';
        $rol = $user['role'] ?? '';
        $userId = $user['id'] ?? null;

        $db = new \Database();
        $db->connectDatabase();
        $ticketModel = new \Ticket($db->getConnection());
        $deviceModel = new \DeviceModel($db->getConnection());

        $cantTickets = 0;
        $cantDevices = 0;

        if ($rol === 'Cliente' && $userId) {
            $tickets = $ticketModel->getTicketsByUserId($userId);
            $cantTickets = is_array($tickets) ? count($tickets) : 0;
            $devices = $deviceModel->getDevicesByUserId($userId);
            $cantDevices = is_array($devices) ? count($devices) : 0;
        } elseif ($rol === 'Tecnico' && $userId) {
            $tickets = $ticketModel->getTicketsByTecnicoId($userId);
            $cantTickets = is_array($tickets) ? count($tickets) : 0;
        } else {
            $tickets = $ticketModel->getAllTickets();
            $cantTickets = is_array($tickets) ? count($tickets) : 0;
            $devices = $deviceModel->getAllDevices();
            $cantDevices = is_array($devices) ? count($devices) : 0;
        }

        // Panel según rol
        $panelUrl = '/ProyectoPandora/Public/index.php?route=Default/Index';
        if ($rol === 'Administrador') {
            $panelUrl = '/ProyectoPandora/Public/index.php?route=Admin/PanelAdmin';
        } elseif ($rol === 'Tecnico') {
            $panelUrl = '/ProyectoPandora/Public/index.php?route=Tecnico/PanelTecnico';
        } elseif ($rol === 'Supervisor') {
            $panelUrl = '/ProyectoPandora/Public/index.php?route=Supervisore/PanelSupervisor';
        } elseif ($rol === 'Cliente') {
            $panelUrl = '/ProyectoPandora/Public/index.php?route=Cliente/PanelCliente';
        }

        // Pasar datos a la vista
        include_once __DIR__ . '/../Views/AllUsers/Perfil.php';
    }
}
