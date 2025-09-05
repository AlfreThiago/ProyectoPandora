<?php
class PanelesController {
    
    public function PanelTecnico() {
        include_once __DIR__ . '/../Views/Paneles/PanelTecnico.php';
    }

    public function PanelCliente(){
        include_once __DIR__ . '/../Views/Paneles/PanelCliente.php';
    }

     public function PanelSupervisor(){
        include_once __DIR__ . '/../Views/Paneles/PanelSupervisor.php';
    }
    public function PanelAdmin(){
        include_once __DIR__ . '/../Views/Admin/PanelAdmin.php';
    }
}
