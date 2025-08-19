<?php
require_once __DIR__ . '/../Models/Ticket.php';
require_once __DIR__ . '/../Core/Database.php';
require_once __DIR__ . '/../Controllers/HistorialController.php';

class TicketController
{
    private $db;
    private $connection;
    private $historialController;

    public function __construct()
    {
        $this->db = new Database();
        $this->db->connectDatabase();
        $this->connection = $this->db->getConnection();
        $this->historialController = new HistorialController();
    }

    // Crear un nuevo ticket
    public function crearTicket()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titulo = $_POST['titulo'] ?? '';
            $descripcion = $_POST['descripcion'] ?? '';

            if (!$titulo || !$descripcion) {
                echo "Todos los campos son obligatorios.";
                return;
            }

            $cliente_id = 1; // Asignar un cliente por defecto (ajustar según sea necesario)
            $prioridad = 'Media'; // Prioridad por defecto
            $estado_id = 1; // Estado por defecto (abierto)
            $tecnico_id = null; // Técnico por defecto (puede ser asignado después)
            $supervisor_id = null; // Supervisor por defecto (puede ser asignado después)

            $ticket = new Ticket($this->connection);
            if ($ticket->crearTicket($cliente_id, $titulo, $descripcion, $prioridad, $estado_id, $tecnico_id, $supervisor_id)) {
                // Guardar en historial
                $accion = "Crear ticket";
                $detalle = "Se creó el ticket '{$titulo}'";
                $this->historialController->agregarAccion($accion, $detalle);

                header('Location: /ProyectoPandora/Public/index.php?route=Ticket/Listar&success=1');
                exit;
            } else {
                echo "Error al crear el ticket.";
            }
        } else {
            include_once __DIR__ . '/../Views/Ticket/CrearTicket.php';
        }
    }

    // Listar todos los tickets
    public function listarTickets()
    {
        $ticket = new Ticket($this->connection);
        $tickets = $ticket->obtenerTodosTickets();
        include_once __DIR__ . '/../Views/Ticket/ListarTickets.php';
    }

    // Ver detalles de un ticket
    public function verTicket()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            echo "Ticket no encontrado.";
            return;
        }
        $ticket = new Ticket($this->connection, $id);
        $detalles = $ticket->obtenerDetalles();
        include_once __DIR__ . '/../Views/Ticket/VerTicket.php';
    }

    // Actualizar estado de un ticket
    public function actualizarEstado()
    {
        $id = $_POST['id'] ?? null;
        $nuevoEstado = $_POST['estado'] ?? '';
        if (!$id || !$nuevoEstado) {
            echo "Datos incompletos.";
            return;
        }
        $ticket = new Ticket($this->connection, $id);
        if ($ticket->actualizarEstado($nuevoEstado)) {
            // Guardar en historial
            $accion = "Actualizar estado de ticket";
            $detalle = "Se actualizó el estado del ticket ID {$id} a '{$nuevoEstado}'";
            $this->historialController->agregarAccion($accion, $detalle);

            header('Location: /ProyectoPandora/Public/index.php?route=Ticket/Ver&id=' . $id . '&success=1');
            exit;
        } else {
            echo "Error al actualizar el estado.";
        }
    }

    // Eliminar un ticket
    public function eliminarTicket()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            echo "Ticket no encontrado.";
            return;
        }
        $ticket = new Ticket($this->connection, $id);
        if ($ticket->eliminarTicket()) {
            // Guardar en historial
            $accion = "Eliminar ticket";
            $detalle = "Se eliminó el ticket ID {$id}";
            $this->historialController->agregarAccion($accion, $detalle);

            header('Location: /ProyectoPandora/Public/index.php?route=Ticket/Listar&deleted=1');
            exit;
        } else {
            echo "Error al eliminar el ticket.";
        }
    }
}
