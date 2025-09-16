<?php    
require_once __DIR__ . '/../Core/Auth.php';
require_once __DIR__ . '/../Models/Ticket.php';
require_once __DIR__ . '/../Core/Database.php';

class TecnicoController {  
    public function PanelTecnico() {
        include_once __DIR__ . '/../Views/Tecnicos/PanelTecnico.php';
    }

    public function MisReparaciones() {
        $user = Auth::user();
        if (!$user || $user['role'] !== 'Tecnico') {
            header('Location: /ProyectoPandora/Public/index.php?route=Auth/Login');
            exit;
        }

        $db = new Database();
        $db->connectDatabase();
        $ticketModel = new Ticket($db->getConnection());

        // Obtener tickets asignados al técnico
        $tickets = $ticketModel->getTicketsByTecnicoId($user['id']);

        include_once __DIR__ . '/../Views/Tecnicos/MisReparaciones.php';
    }
}