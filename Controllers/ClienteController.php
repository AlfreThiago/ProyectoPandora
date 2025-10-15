<?php
require_once __DIR__ . '/../Models/Ticket.php';
require_once __DIR__ . '/../Models/Device.php';
require_once __DIR__ . '/../Core/Database.php';
require_once __DIR__ . '/../Core/Auth.php';

class ClienteController {
    // Helpers de presentación pedidos en el controlador
    private function estadoBadgeClass(?string $estado): string {
        $s = strtolower(trim($estado ?? ''));
        if (in_array($s, ['abierto','nuevo','recibido'], true)) return 'badge';
        if (in_array($s, ['en proceso','diagnóstico','diagnostico','reparación','reparacion','en reparación'], true)) return 'badge badge--success';
        if (in_array($s, ['en espera','pendiente'], true)) return 'badge';
        if (in_array($s, ['finalizado','cerrado','cancelado'], true)) return 'badge badge--danger';
        return 'badge badge--muted';
    }
    private function puedeEliminarTicket(?string $estado): bool {
        return strtolower(trim($estado ?? '')) === 'nuevo';
    }
    
    public function PanelCliente(){
        header('Location: /ProyectoPandora/Public/index.php?route=Cliente/MisDevice');
        exit;
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

        
        $dispositivos = $deviceModel->getDevicesByUserId($user['id']);

        include_once __DIR__ . '/../Views/Clientes/MisDevice.php';
    }

    // Compat: redirige a activos para ruta antigua
    public function MisTicket() {
        header('Location: /ProyectoPandora/Public/index.php?route=Cliente/MisTicketActivo');
        exit;
    }

    public function MisTicketActivo() {
        $user = Auth::user();
        if (!$user) { header('Location: /ProyectoPandora/Public/index.php?route=Auth/Login'); exit; }
        $db = new Database(); $db->connectDatabase(); $ticketModel = new Ticket($db->getConnection());
        $tickets = $ticketModel->getTicketsActivosByUserId($user['id']);
        // Enriquecer datos para la vista (sin lógica en la vista)
        foreach ($tickets as &$t) {
            $t['estadoClass'] = $this->estadoBadgeClass($t['estado'] ?? '');
            $t['puedeEliminar'] = $this->puedeEliminarTicket($t['estado'] ?? '');
        }
        unset($t);
        include_once __DIR__ . '/../Views/Clientes/MisTicketActivo.php';
    }

    public function MisTicketTerminados() {
        $user = Auth::user();
        if (!$user) { header('Location: /ProyectoPandora/Public/index.php?route=Auth/Login'); exit; }
        $db = new Database(); $db->connectDatabase(); $ticketModel = new Ticket($db->getConnection());
        $tickets = $ticketModel->getTicketsTerminadosByUserId($user['id']);
        foreach ($tickets as &$t) {
            $t['estadoClass'] = $this->estadoBadgeClass($t['estado'] ?? '');
            $t['puedeEliminar'] = $this->puedeEliminarTicket($t['estado'] ?? '');
        }
        unset($t);
        include_once __DIR__ . '/../Views/Clientes/MisTicketTerminados.php';
    }
}

?>