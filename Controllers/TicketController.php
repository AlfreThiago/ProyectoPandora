<?php
require_once __DIR__ . '/../Models/Ticket.php';
require_once __DIR__ . '/../Core/Database.php';
require_once __DIR__ . '/../Core/Auth.php';
require_once __DIR__ . '/../Models/Device.php';
require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/HistorialController.php';
require_once __DIR__ . '/../Models/EstadoTicket.php';

class TicketController
{
    private $ticketModel;
    private $deviceModel;
    private $userModel;
    private $estadoModel;
    private $historialController;

    public function __construct()
    {
        $db = new Database();
        $db->connectDatabase();
        $this->ticketModel = new Ticket($db->getConnection());
        $this->deviceModel = new DeviceModel($db->getConnection());
        $this->userModel = new UserModel($db->getConnection());
        $this->estadoModel = new EstadoTicketModel($db->getConnection());
        $this->historialController = new HistorialController();
    }

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

    public function verTicket($id)
    {
        $user = Auth::user();
        if (!$user) {
            header('Location: /ProyectoPandora/Public/index.php?route=Auth/Login');
            exit;
        }

        // Solo permite acceso a roles válidos
        $rolesPermitidos = ['Administrador', 'Supervisor', 'Tecnico', 'Cliente'];
        if (!in_array($user['role'], $rolesPermitidos)) {
            header('Location: /ProyectoPandora/Public/index.php?route=Default/Index');
            exit;
        }

        $ticket = $this->ticketModel->ver($id);

        // Si es cliente, verifica que el ticket le pertenezca
        if ($user['role'] === 'Cliente') {
            if ($ticket['cliente'] !== $user['name']) {
                header('Location: /ProyectoPandora/Public/index.php?route=Cliente/PanelCliente');
                exit;
            }
        }

        include __DIR__ . '/../Views/Ticket/VerTicket.php';
    }

    public function edit($id)
    {
        $user = Auth::user();
        $rol = $user['role'];
        $ticket = $this->ticketModel->ver($id);
        $estados = $this->estadoModel->getAllEstados();
        $tecnicos = $this->userModel->getAllTecnicos();

        include_once __DIR__ . '/../Views/Ticket/ActualizarTicket.php';
    }

    public function actualizar()
    {
        $user = Auth::user();
        $rol = $user['role'];
        $id = $_POST['id'];
        $descripcion = $_POST['descripcion_falla'];

        $estado_id = $_POST['estado_id'] ?? null;
        $tecnico_id = $_POST['tecnico_id'] ?? null;
        if ($tecnico_id === '' || $tecnico_id === null) {
            $tecnico_id = null;
        }

        // Obtener el técnico anterior (si existía)
        $ticketActual = $this->ticketModel->ver($id);
        $old_tecnico_id = $ticketActual['tecnico_id'] ?? null;

        $this->ticketModel->actualizarCompleto($id, $descripcion, $estado_id, $tecnico_id);

        // Si se asigna un técnico, ponerlo como "Ocupado"
        if ($tecnico_id) {
            $this->userModel->setTecnicoEstado($tecnico_id, 'Ocupado');
        }
        // Si se desasigna el técnico anterior, ponerlo como "Disponible"
        if ($old_tecnico_id && $tecnico_id !== $old_tecnico_id) {
            $this->userModel->setTecnicoEstado($old_tecnico_id, 'Disponible');
        }

        // Redirección según rol
        if ($rol === 'Cliente') {
            header('Location: /ProyectoPandora/Public/index.php?route=Cliente/MisTicket');
        } else {
            header('Location: /ProyectoPandora/Public/index.php?route=Ticket/Listar');
        }
        exit;
    }

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

            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cliente_id'])) {
                $cliente_id = $_POST['cliente_id'];
            }
        } else {
            $cliente = $this->ticketModel->obtenerClientePorUser($user['id']);
            $cliente_id = $cliente['id'];
        }

        $data = [];
        if ($cliente_id) {
            $dispositivos = $this->ticketModel->obtenerDispositivosPorCliente($cliente_id);
            while ($row = $dispositivos->fetch_assoc()) {
                $data[] = $row;
            }
        }
        
        include __DIR__ . '/../Views/Ticket/CrearTicket.php';
    }

    public function crear()
    {
        $user = Auth::user();
        if (!$user) {
            header('Location: /ProyectoPandora/Public/index.php?route=Auth/Login');
            exit;
        }

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

        if (empty($dispositivo_id)) {
            header('Location: /ProyectoPandora/Public/index.php?route=Ticket/mostrarCrear&error=Debe seleccionar un dispositivo');
            exit;
        }

        $this->ticketModel->crear($cliente_id, $dispositivo_id, $descripcion);

        // Historial: creación de ticket
        $accion = "Creación de ticket";
        $detalle = "Usuario {$user['name']} creó un ticket para el dispositivo ID {$dispositivo_id} con descripción: {$descripcion}";
        $this->historialController->agregarAccion($accion, $detalle);

        // Redirección según rol
        if ($user['role'] === 'Cliente') {
            header('Location: /ProyectoPandora/Public/index.php?route=Cliente/MisTicket');
        } else {
            header('Location: /ProyectoPandora/Public/index.php?route=Ticket/Listar');
        }
        exit;
    }

    public function eliminar()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header("Location: /ProyectoPandora/Public/index.php?route=Ticket/Listar&error=ID de ticket no especificado");
            exit;
        }
        $user = Auth::user();
        if (!$user) {
            header('Location: /ProyectoPandora/Public/index.php?route=Auth/Login');
            exit;
        }
        if ($this->ticketModel->deleteTicket($id)) {
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
