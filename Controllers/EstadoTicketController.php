<?php
require_once __DIR__ . '/../Models/EstadoTicket.php';
require_once __DIR__ . '/../Core/Database.php';

class EstadoTicketController
{
    private $estadoModel;

    public function __construct()
    {
        $db = new Database();
        $db->connectDatabase();
        $this->estadoModel = new EstadoTicketModel($db->getConnection());
    }

    public function listar()
    {
        require_once __DIR__ . '/../Core/Auth.php';
        Auth::checkRole('Administrador');
        $estados = $this->estadoModel->obtenerTodos();
        include_once __DIR__ . '/../../ProyectoPandora/Views/EstadoTicket/Listar.php';
    }

    public function crear()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            if ($name) {
                $this->estadoModel->crear($name);
                header('Location: /ProyectoPandora/Public/index.php?route=EstadoTicket/Listar');
                exit;
            }
        }
        include_once __DIR__ . '/../Views/EstadoTicket/Crear.php';
    }

    public function eliminar()
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->estadoModel->eliminar($id);
            header('Location: /ProyectoPandora/Public/index.php?route=EstadoTicket/Listar');
            exit;
        }
    }
}
