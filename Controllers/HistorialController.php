<?php
require_once '../Core/Database.php';
require_once '../Models/Historial.php';

class HistorialController
{
    private $historialModel;
    public function __construct()
    {
        $db = new Database();
        $db->connectDatabase();
        $this->historialModel = new Historial($db->getConnection());
    }
    public function agregarAccion($accion, $detalle)
    {
        return $this->historialModel->agregarAccion($accion, $detalle);
    }
}
