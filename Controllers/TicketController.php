<?php
require_once __DIR__ . '/../Models/Ticket.php';
require_once __DIR__ . '/../Core/Database.php';
require_once __DIR__ . '/../Core/Auth.php';
require_once __DIR__ . '/../Models/Device.php';
require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/HistorialController.php';
require_once __DIR__ . '/../Models/EstadoTicket.php';
require_once __DIR__ . '/../Models/Rating.php';

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
        if ($user['role'] === 'Administrador') {
            header('Location: /ProyectoPandora/Public/index.php?route=Default/Index');
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
    $rolesPermitidos = ['Supervisor', 'Tecnico', 'Cliente'];
        if (!in_array($user['role'], $rolesPermitidos)) {
            header('Location: /ProyectoPandora/Public/index.php?route=Default/Index');
            exit;
        }

        $ticket = $this->ticketModel->ver($id);

        // Si es cliente, verifica que el ticket le pertenezca
        if ($user['role'] === 'Cliente') {
            if ($ticket['cliente'] !== $user['name']) {
                header('Location: /ProyectoPandora/Public/index.php?route=Cliente/MisTicket');
                exit;
            }
        }

        include __DIR__ . '/../Views/Ticket/VerTicket.php';
    }

    public function Calificar() {
        $user = Auth::user();
        if (!$user || $user['role'] !== 'Cliente') {
            header('Location: /ProyectoPandora/Public/index.php?route=Auth/Login');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /ProyectoPandora/Public/index.php?route=Cliente/MisTicket');
            exit;
        }
        $ticket_id = (int)($_POST['ticket_id'] ?? 0);
        $stars = max(1, min(5, (int)($_POST['stars'] ?? 0)));
        $comment = trim($_POST['comment'] ?? '');

        $db = new Database();
        $db->connectDatabase();
        $ticketModel = new Ticket($db->getConnection());
        $ratingModel = new RatingModel($db->getConnection());

        $tk = $ticketModel->ver($ticket_id);
        if (!$tk) { header('Location: /ProyectoPandora/Public/index.php?route=Cliente/MisTicket&error=ticket'); exit; }

        // Validar que el estado sea Finalizado/Cerrado antes de permitir calificar
        $estadoTxt = strtolower(trim($tk['estado'] ?? ''));
        if (!in_array($estadoTxt, ['finalizado', 'cerrado'], true)) {
            header('Location: /ProyectoPandora/Public/index.php?route=Ticket/Ver&id=' . $ticket_id . '&error=estado');
            exit;
        }

        // Resolver ids relacionales
        $conn = $db->getConnection();
        $stmtC = $conn->prepare("SELECT id FROM clientes WHERE user_id = ? LIMIT 1");
        $stmtC->bind_param("i", $user['id']);
        $stmtC->execute();
        $cliente = $stmtC->get_result()->fetch_assoc();
        // Obtener tecnico y cliente propietario del ticket
        $stmtT = $conn->prepare("SELECT t.tecnico_id, t.cliente_id FROM tickets t WHERE t.id = ? LIMIT 1");
        $stmtT->bind_param("i", $ticket_id);
        $stmtT->execute();
        $rowT = $stmtT->get_result()->fetch_assoc();
        $tecnico_id = $rowT['tecnico_id'] ?? null;
        $owner_cliente_id = $rowT['cliente_id'] ?? null;

        // Validar pertenencia del ticket y existencia de técnico asignado
        if (!$cliente || !$tecnico_id || (int)$owner_cliente_id !== (int)$cliente['id']) {
            header('Location: /ProyectoPandora/Public/index.php?route=Cliente/MisTicket&error=forbidden');
            exit;
        }

        $ratingModel->save($ticket_id, (int)$tecnico_id, (int)$cliente['id'], $stars, $comment);
        header('Location: /ProyectoPandora/Public/index.php?route=Ticket/Ver&id=' . $ticket_id . '&rated=1');
        exit;
    }

    public function edit($id)
    {
        $user = Auth::user();
        $rol = $user['role'];
        if ($rol === 'Administrador') {
            header('Location: /ProyectoPandora/Public/index.php?route=Default/Index');
            exit;
        }
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

        // Nota: la disponibilidad del técnico se gestiona desde su perfil por el propio técnico.

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

    $isAdmin = false; // Administrador no gestiona tickets
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

        // Verifica que existan estados
        $estados = $this->estadoModel->getAllEstados();
        if (empty($estados)) {
            $errorMsg = "Primero debes crear al menos un estado antes de poder crear un ticket.";
            include __DIR__ . '/../Views/Ticket/CrearTicket.php';
            return;
        }

        // Verifica que existan dispositivos
        if (empty($data)) {
            $errorMsg = "Primero debes crear al menos un dispositivo antes de poder crear un ticket.";
            include __DIR__ . '/../Views/Ticket/CrearTicket.php';
            return;
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

    $isAdmin = false; // Administrador no gestiona tickets
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
        if ($user['role'] === 'Administrador') {
            header('Location: /ProyectoPandora/Public/index.php?route=Default/Index');
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

    public function mostrarCrearItem()
    {
        $user = Auth::user();
        if (!$user) {
            header('Location: /ProyectoPandora/Public/index.php?route=Auth/Login');
            exit;
        }

        $db = new Database();
        $db->connectDatabase();
        $categoryModel = new CategoryModel($db->getConnection());
        $categorias = $categoryModel->getAllInventarioCategories();

        if (empty($categorias)) {
            $errorMsg = "Primero debes crear al menos una categoría de inventario antes de poder agregar un item.";
            include_once __DIR__ . '/../Views/Inventario/CrearItem.php';
            return;
        }

        // ... lógica normal para mostrar el formulario ...
        include_once __DIR__ . '/../Views/Inventario/CrearItem.php';
    }
}
