<?php
require_once __DIR__ . '/../Models/Ticket.php';
require_once __DIR__ . '/../Models/Device.php';
require_once __DIR__ . '/../Core/Database.php';
require_once __DIR__ . '/../Core/Auth.php';

class ClienteController {
    
    public function PanelCliente(){
        include_once __DIR__ . '/../Views/Clientes/PanelCliente.php';
    }

    public function MisDevice() {
        $user = Auth::user();
        if (!$user) {
            header('Location: /ProyectoPandora/Public/index.php?route=Auth/Login');
            exit;
        }

        $db = new Database();
        $db->connectDatabase();
        $deviceModel = new DeviceModel($db->getConnection());

        // Obtener dispositivos del usuario logueado
        $dispositivos = $deviceModel->getDevicesByUserId($user['id']);

        include_once __DIR__ . '/../Views/Clientes/MisDevice.php';
    }

    public function MisTicket() {
        $user = Auth::user();
        if (!$user) {
            header('Location: /ProyectoPandora/Public/index.php?route=Auth/Login');
            exit;
        }

        $db = new Database();
        $db->connectDatabase();
        $ticketModel = new Ticket($db->getConnection());

        // Obtener tickets del usuario logueado
        $tickets = $ticketModel->getTicketsByUserId($user['id']);

        include_once __DIR__ . '/../Views/Clientes/MisTicket.php';
    }
}

?>