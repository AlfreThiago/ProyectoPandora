<?php
class Ticket
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function crear($cliente_id, $dispositivo_id, $descripcion_falla)
    {
        $sql = "INSERT INTO tickets (cliente_id, dispositivo_id, descripcion_falla, estado_id) 
                VALUES (?, ?, ?, 1)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iis", $cliente_id, $dispositivo_id, $descripcion_falla);
        return $stmt->execute();
    }

    public function listar()
    {
        $sql = "SELECT 
                    t.id,
                    d.marca AS dispositivo,
                    d.modelo,
                    u.name AS cliente,
                    t.descripcion_falla AS descripcion,
                    e.name AS estado,
                    tec.name AS tecnico
                FROM tickets t
                INNER JOIN dispositivos d ON t.dispositivo_id = d.id
                INNER JOIN clientes c ON t.cliente_id = c.id
                INNER JOIN users u ON c.user_id = u.id
                INNER JOIN estados_tickets e ON t.estado_id = e.id
                LEFT JOIN tecnicos tc ON t.tecnico_id = tc.id
                LEFT JOIN users tec ON tc.user_id = tec.id
                ORDER BY t.id DESC";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function ver($id)
    {
        $sql = "SELECT 
                    t.id,
                    d.marca,
                    d.modelo,
                    d.img_dispositivo,
                    u.name AS cliente,
                    t.descripcion_falla AS descripcion,
                    e.name AS estado,
                    tec.name AS tecnico,
                    t.fecha_creacion,
                    t.fecha_cierre
                FROM tickets t
                INNER JOIN dispositivos d ON t.dispositivo_id = d.id
                INNER JOIN clientes c ON t.cliente_id = c.id
                INNER JOIN users u ON c.user_id = u.id
                INNER JOIN estados_tickets e ON t.estado_id = e.id
                LEFT JOIN tecnicos tc ON t.tecnico_id = tc.id
                LEFT JOIN users tec ON tc.user_id = tec.id
                WHERE t.id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function actualizar($id, $descripcion_falla)
    {
        $sql = "UPDATE tickets SET descripcion_falla = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $descripcion_falla, $id);
        return $stmt->execute();
    }

    public function deleteTicket($ticketId)
    {
        $stmt = $this->conn->prepare("DELETE FROM tickets WHERE id = ?");
        if ($stmt) {
            $stmt->bind_param("i", $ticketId);
            return $stmt->execute();
        }
        return false;
    }
    public function obtenerDispositivosPorCliente($cliente_id)
    {
        
        $sql = "SELECT d.id, d.marca, d.modelo, d.descripcion_falla 
                FROM dispositivos d
                INNER JOIN clientes c ON d.user_id = c.user_id
                WHERE c.id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $cliente_id);
        $stmt->execute();
        return $stmt->get_result();
    }
    public function obtenerClientePorUser($user_id)
    {
        $sql = "SELECT id FROM clientes WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    public function getTicketsByUserId($user_id)
    {
        $sql = "SELECT 
                    t.id,
                    d.marca AS dispositivo,
                    d.modelo,
                    t.descripcion_falla,
                    e.name AS estado,
                    t.fecha_creacion,
                    tec.name AS tecnico
                FROM tickets t
                INNER JOIN dispositivos d ON t.dispositivo_id = d.id
                INNER JOIN clientes c ON t.cliente_id = c.id
                INNER JOIN estados_tickets e ON t.estado_id = e.id
                LEFT JOIN tecnicos tc ON t.tecnico_id = tc.id
                LEFT JOIN users tec ON tc.user_id = tec.id
                WHERE c.user_id = ?
                ORDER BY t.fecha_creacion DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }
    public function actualizarDescripcion($id, $descripcion)
    {
        $stmt = $this->conn->prepare("UPDATE tickets SET descripcion_falla = ? WHERE id = ?");
        $stmt->bind_param("si", $descripcion, $id);
        return $stmt->execute();
    }

    public function actualizarCompleto($id, $descripcion, $estado_id, $tecnico_id)
    {
        
        $campos = [ 'descripcion_falla = ?' ];
        $types = 's';
        $params = [ $descripcion ];

        if ($estado_id !== null) {
            $campos[] = 'estado_id = ?';
            $types .= 'i';
            $params[] = (int)$estado_id;
        }

        
        $campos[] = 'tecnico_id = ?';
        $types .= 'i';
        
        $params[] = $tecnico_id; 

        $sql = 'UPDATE tickets SET ' . implode(', ', $campos) . ' WHERE id = ?';
        $types .= 'i';
        $params[] = (int)$id;

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return false;
        
        $stmt->bind_param($types, ...$params);
        return $stmt->execute();
    }
    public function getTicketsByTecnicoId($tecnico_user_id)
    {
        $sql = "SELECT 
                    t.id,
                    d.marca,
                    d.modelo,
                    d.img_dispositivo,
                    u.name AS cliente,
                    t.descripcion_falla,
                    e.name AS estado,
                    t.fecha_creacion
                FROM tickets t
                INNER JOIN dispositivos d ON t.dispositivo_id = d.id
                INNER JOIN clientes c ON t.cliente_id = c.id
                INNER JOIN users u ON c.user_id = u.id
                INNER JOIN estados_tickets e ON t.estado_id = e.id
                INNER JOIN tecnicos tc ON t.tecnico_id = tc.id
                WHERE tc.user_id = ?
                ORDER BY t.fecha_creacion DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $tecnico_user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }
    public function getAllTickets()
    {
        $sql = "SELECT 
                    t.id,
                    d.marca AS dispositivo,
                    d.modelo,
                    u.name AS cliente,
                    t.descripcion_falla AS descripcion,
                    e.name AS estado,
                    tec.name AS tecnico
                FROM tickets t
                INNER JOIN dispositivos d ON t.dispositivo_id = d.id
                INNER JOIN clientes c ON t.cliente_id = c.id
                INNER JOIN users u ON c.user_id = u.id
                INNER JOIN estados_tickets e ON t.estado_id = e.id
                LEFT JOIN tecnicos tc ON t.tecnico_id = tc.id
                LEFT JOIN users tec ON tc.user_id = tec.id
                ORDER BY t.id DESC";
        $result = $this->conn->query($sql);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }   

    public function getTicketsSinTecnico()
    {
        $sql = "SELECT 
                    t.id,
                    d.marca AS dispositivo,
                    d.modelo,
                    u.name AS cliente,
                    t.descripcion_falla AS descripcion,
                    e.name AS estado
                FROM tickets t
                INNER JOIN dispositivos d ON t.dispositivo_id = d.id
                INNER JOIN clientes c ON t.cliente_id = c.id
                INNER JOIN users u ON c.user_id = u.id
                INNER JOIN estados_tickets e ON t.estado_id = e.id
                WHERE t.tecnico_id IS NULL
                ORDER BY t.id DESC";
        $result = $this->conn->query($sql);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }

    public function asignarTecnico($ticket_id, $tecnico_id)
    {
        $sql = "UPDATE tickets SET tecnico_id = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $tecnico_id, $ticket_id);
        return $stmt->execute();
    }

    public function getSupervisorId($ticket_id)
    {
        $stmt = $this->conn->prepare("SELECT supervisor_id FROM tickets WHERE id = ? LIMIT 1");
        if (!$stmt) return null;
        $stmt->bind_param("i", $ticket_id);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        return $res['supervisor_id'] ?? null;
    }

    public function asignarSupervisor($ticket_id, $supervisor_id)
    {
        $stmt = $this->conn->prepare("UPDATE tickets SET supervisor_id = ? WHERE id = ?");
        if (!$stmt) return false;
        $stmt->bind_param("ii", $supervisor_id, $ticket_id);
        return $stmt->execute();
    }

    /**
     * Retorna true si existe al menos un ticket ACTIVO para el dispositivo dado.
     * Activo = estado distinto de Finalizado, Cerrado o Cancelado.
     */
    public function hasActiveTicketForDevice(int $dispositivo_id): bool
    {
        $sql = "SELECT COUNT(*) AS c
                FROM tickets t
                INNER JOIN estados_tickets e ON e.id = t.estado_id
                WHERE t.dispositivo_id = ?
                  AND LOWER(e.name) NOT IN ('finalizado','cerrado','cancelado')";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return false;
        $stmt->bind_param("i", $dispositivo_id);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        return ((int)($res['c'] ?? 0)) > 0;
    }
}
