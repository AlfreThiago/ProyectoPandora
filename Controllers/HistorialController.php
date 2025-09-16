<?php
require_once '../Core/Database.php';
require_once '../Models/Historial.php';
require_once __DIR__ . '/../Core/Auth.php';
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
    public function obtenerHistorial()
    {
        return $this->historialModel->obtenerHistorial();
    }
    public function listarHistorial()
    {
        Auth::checkRole('Administrador');
        $historialController = new HistorialController();
        $historial = $historialController->obtenerHistorial();
        include_once __DIR__ . '/../Views/Admin/Historial.php';
    }
}
