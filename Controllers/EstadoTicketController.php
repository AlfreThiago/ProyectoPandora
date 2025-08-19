<?php
require_once __DIR__ . '/../Models/EstadoTicket.php';
require_once __DIR__ . '/../Core/Database.php';
require_once __DIR__ . '/../Core/Auth.php';

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
        Auth::checkRole('Administrador');
        $estados = $this->estadoModel->obtenerTodos();
        include_once __DIR__ . '/../../ProyectoPandora/Views/EstadoTicket/Listar.php';
    }

    public function crear()
    {
        Auth::checkRole('Administrador');
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
    public function editar($id = null)
    {
        Auth::checkRole('Administrador');
        if ($id === null && isset($_GET['id'])) {
            $id = $_GET['id'];
        }

        if ($id === null) {
            die("Error: no se recibió ID para editar.");
        }

        $estado = $this->estadoModel->getById($id);
        include_once __DIR__ . '/../Views/EstadoTicket/Actualizar.php';
    }


    public function actualizar()
    {
        Auth::checkRole('Administrador');
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id = $_POST['id'];
            $name = $_POST['name'];

            if ($this->estadoModel->updateEstado($id, $name)) {
                header("Location: /ProyectoPandora/Public/index.php?route=EstadoTicket/Listar");
                exit();
            } else {
                header('Location: /ProyectoPandora/Public/index.php?route=EstadoTicket/Listar');
                exit();
            }
        }
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
