<?php
require_once __DIR__ . '/../Models/Ticket.php';
require_once __DIR__ . '/../Core/Database.php';
require_once __DIR__ . '/../Core/Auth.php';
require_once __DIR__ . '/../Models/Device.php';

class TicketController
{
    private $ticketModel;

    public function __construct()
    {
        $db = new Database();
        $db->connectDatabase();
        $this->ticketModel = new Ticket($db->getConnection());
    }

    // Mostrar lista
    public function mostrarLista()
    {
        $user = Auth::user();
        if (!$user) {
            header('Location: /ProyectoPandora/Public/index.php?route=Auth/Login');
            exit;
        }
        $tickets = $this->ticketModel->listar();
        $data = [];
        while ($row = $tickets->fetch_assoc()) {
            $data[] = $row;
        }
        include __DIR__ . '/../Views/Ticket/ListarTickets.php';
    }

    // Mostrar un ticket
    public function verTicket($id)
    {
        $user = Auth::user();
        if (!$user) {
            header('Location: /ProyectoPandora/Public/index.php?route=Auth/Login');
            exit;
        }
        $ticket = $this->ticketModel->ver($id);
        include __DIR__ . '/../Views/Ticket/VerTicket.php';
    }

    // Editar un ticket
    public function edit($id)
    {
        $user = Auth::user();
        if (!$user) {
            header('Location: /ProyectoPandora/Public/index.php?route=Auth/Login');
            exit;
        }
        $ticket = $this->ticketModel->ver($id);
        include __DIR__ . '/../Views/Ticket/ActualizarTicket.php';
    }

    // Guardar cambios en edición
    public function update($id, $descripcion)
    {
        $user = Auth::user();
        if (!$user) {
            header('Location: /ProyectoPandora/Public/index.php?route=Auth/Login');
            exit;
        }
        $this->ticketModel->actualizar($id, $descripcion);
        header("Location: ListarTickets.php");
    }

    // Crear ticket
    // Mostrar formulario de creación
    // Mostrar formulario para crear ticket
    public function mostrarCrear()
    {
        $user = Auth::user();
        if (!$user) {
            header('Location: /ProyectoPandora/Public/index.php?route=Auth/Login');
            exit;
        }

        // Traer dispositivos del cliente logueado
        $dispositivos = $this->ticketModel->obtenerDispositivosPorCliente($user['id']);

        $data = [];
        while ($row = $dispositivos->fetch_assoc()) {
            $data[] = $row;
        }

        include __DIR__ . '/../Views/Ticket/CrearTicket.php';
    }


    // Crear ticket
    public function crear()
    {
        $user = Auth::user();
        if (!$user) {
            header('Location: /ProyectoPandora/Public/index.php?route=Auth/Login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cliente = $this->ticketModel->obtenerClientePorUser($user['id']);
            if (!$cliente) {
                die("Error: el usuario no tiene cliente asociado.");
            }

            $cliente_id = $cliente['id'];
            $dispositivo_id = $_POST['dispositivo_id'];
            $descripcion = $_POST['descripcion'];

            $this->ticketModel->crear($cliente_id, $dispositivo_id, $descripcion);

            header('Location: /ProyectoPandora/Public/index.php?route=Ticket/Listar');
            exit;
        }
    }



    // Eliminar ticket
    public function eliminar($id)
    {
        $user = Auth::user();
        if (!$user) {
            header('Location: /ProyectoPandora/Public/index.php?route=Auth/Login');
            exit;
        }
        $this->ticketModel->eliminar($id);
        header("Location: ListarTicket.php");
    }
}
