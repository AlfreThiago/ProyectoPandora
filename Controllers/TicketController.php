<?php
require_once __DIR__ . '/../Models/Ticket.php';
require_once __DIR__ . '/../Core/Database.php';
require_once __DIR__ . '/../Core/Auth.php';
require_once __DIR__ . '/../Models/Device.php';
require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/HistorialController.php';

class TicketController
{
    private $ticketModel;
    private $historialController;

    public function __construct()
    {
        $db = new Database();
        $db->connectDatabase();
        $this->ticketModel = new Ticket($db->getConnection());
        $this->historialController = new HistorialController();
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

        $accion = "Actualización de ticket";
        $detalle = "Usuario {$user['name']} actualizó el ticket ID {$id} con nueva descripción: {$descripcion}";
        $this->historialController->agregarAccion($accion, $detalle);

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

        $isAdmin = ($user['role'] === 'Administrador');
        $clientes = [];
        $cliente_id = null;

        if ($isAdmin) {
            $db = new Database();
            $db->connectDatabase();
            $userModel = new UserModel($db->getConnection());
            $clientes = $userModel->getAllClientes();

            // Si el admin seleccionó un cliente, usamos ese id
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cliente_id'])) {
                $cliente_id = $_POST['cliente_id'];
            }
        } else {
            // Si es cliente, usamos su propio id
            $cliente = $this->ticketModel->obtenerClientePorUser($user['id']);
            $cliente_id = $cliente['id'];
        }

        // Obtener dispositivos solo si hay cliente seleccionado
        $data = [];
        if ($cliente_id) {
            $dispositivos = $this->ticketModel->obtenerDispositivosPorCliente($cliente_id);
            while ($row = $dispositivos->fetch_assoc()) {
                $data[] = $row;
            }
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

        // Si es recarga de cliente, solo mostrar el formulario con los dispositivos del cliente seleccionado
        if (isset($_POST['recarga_cliente']) && $_POST['recarga_cliente'] === '1') {
            $this->mostrarCrear();
            return;
        }

        $isAdmin = ($user['role'] === 'Administrador');
        if ($isAdmin && isset($_POST['cliente_id'])) {
            $cliente_id = $_POST['cliente_id'];
        } else {
            $cliente = $this->ticketModel->obtenerClientePorUser($user['id']);
            if (!$cliente) {
                die("Error: el usuario no tiene cliente asociado.");
            }
            $cliente_id = $cliente['id'];
        }

        $dispositivo_id = $_POST['dispositivo_id'] ?? '';
        $descripcion = $_POST['descripcion'] ?? '';

        // Validación: dispositivo_id no puede estar vacío
        if (empty($dispositivo_id)) {
            header('Location: /ProyectoPandora/Public/index.php?route=Ticket/mostrarCrear&error=Debe seleccionar un dispositivo');
            exit;
        }

        $this->ticketModel->crear($cliente_id, $dispositivo_id, $descripcion);

        // Guardar en historial
        $user = Auth::user();
        $accion = "Creación de ticket";
        $detalle = "Usuario {$user['name']} creó un ticket para el dispositivo ID {$dispositivo_id} con descripción: {$descripcion}";
        $this->historialController->agregarAccion($accion, $detalle);

        header('Location: /ProyectoPandora/Public/index.php?route=Ticket/Listar');
        exit;
    }



    // Eliminar ticket
    public function eliminar()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            // Puedes mostrar un mensaje de error o redirigir
            header("Location: /ProyectoPandora/Public/index.php?route=Ticket/Listar&error=ID de ticket no especificado");
            exit;
        }
        $user = Auth::user();
        if (!$user) {
            header('Location: /ProyectoPandora/Public/index.php?route=Auth/Login');
            exit;
        }
        if ($this->ticketModel->deleteTicket($id)) {
            $user = Auth::user();
            $accion = "Eliminación de ticket";
            $detalle = "Usuario {$user['name']} eliminó el ticket ID {$id}";
            $this->historialController->agregarAccion($accion, $detalle);

            header("Location: /ProyectoPandora/Public/index.php?route=Ticket/Listar&success=1");
        } else {
            header("Location: /ProyectoPandora/Public/index.php?route=Ticket/Listar&error=No se pudo eliminar el ticket");
        }
        exit;
    }
}
