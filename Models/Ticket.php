<?php
class Ticket
{
    private $connection;
    private $id;
    private $cliente_id;
    private $tecnico_id;
    private $supervisor_id;
    private $estado_id;
    private $titulo;
    private $descripcion;
    private $prioridad;
    private $fecha_creacion;
    private $fecha_cierre;

    public function __construct($dbConnection, $id = null)
    {
        $this->connection = $dbConnection;
        if ($id) {
            $this->id = $id;
            $this->cargarTicket();
        }
    }

    private function cargarTicket()
    {
        $stmt = $this->connection->prepare("SELECT * FROM tickets WHERE id = ?");
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($ticket = $result->fetch_assoc()) {
            $this->cliente_id = $ticket['cliente_id'];
            $this->tecnico_id = $ticket['tecnico_id'];
            $this->supervisor_id = $ticket['supervisor_id'];
            $this->estado_id = $ticket['estado_id'];
            $this->titulo = $ticket['titulo'];
            $this->descripcion = $ticket['descripcion'];
            $this->prioridad = $ticket['prioridad'];
            $this->fecha_creacion = $ticket['fecha_creacion'];
            $this->fecha_cierre = $ticket['fecha_cierre'];
        }
    }

    public function crearTicket($cliente_id, $titulo, $descripcion, $prioridad = 'Media', $estado_id = 1, $tecnico_id = null, $supervisor_id = null)
    {
        $stmt = $this->connection->prepare(
            "INSERT INTO tickets (cliente_id, titulo, descripcion, prioridad, estado_id, tecnico_id, supervisor_id) VALUES (?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->bind_param("isssiii", $cliente_id, $titulo, $descripcion, $prioridad, $estado_id, $tecnico_id, $supervisor_id);
        return $stmt->execute();
    }

    public function actualizarEstado($nuevoEstadoId)
    {
        $stmt = $this->connection->prepare("UPDATE tickets SET estado_id = ? WHERE id = ?");
        $stmt->bind_param("ii", $nuevoEstadoId, $this->id);
        return $stmt->execute();
    }

    public function actualizarPrioridad($nuevaPrioridad)
    {
        $stmt = $this->connection->prepare("UPDATE tickets SET prioridad = ? WHERE id = ?");
        $stmt->bind_param("si", $nuevaPrioridad, $this->id);
        return $stmt->execute();
    }

    public function cerrarTicket()
    {
        $stmt = $this->connection->prepare("UPDATE tickets SET fecha_cierre = NOW(), estado_id = ? WHERE id = ?");
        // Suponiendo que el estado cerrado es 3 (ajusta según tu tabla estados_tickets)
        $estadoCerrado = 3;
        $stmt->bind_param("ii", $estadoCerrado, $this->id);
        return $stmt->execute();
    }

    public function eliminarTicket()
    {
        $stmt = $this->connection->prepare("DELETE FROM tickets WHERE id = ?");
        $stmt->bind_param("i", $this->id);
        return $stmt->execute();
    }

    public function obtenerDetalles()
    {
        return [
            'id' => $this->id,
            'cliente_id' => $this->cliente_id,
            'tecnico_id' => $this->tecnico_id,
            'supervisor_id' => $this->supervisor_id,
            'estado_id' => $this->estado_id,
            'titulo' => $this->titulo,
            'descripcion' => $this->descripcion,
            'prioridad' => $this->prioridad,
            'fecha_creacion' => $this->fecha_creacion,
            'fecha_cierre' => $this->fecha_cierre
        ];
    }

    public function obtenerTodosTickets()
    {
        $stmt = $this->connection->prepare("SELECT * FROM tickets ORDER BY fecha_creacion DESC");
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
