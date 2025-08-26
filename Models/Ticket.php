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
        $sql = "SELECT t.id, d.marca AS dispositivo, u.name AS cliente, 
                       t.descripcion_falla, e.name AS estado, 
                       us.name AS tecnico
                FROM tickets t
                INNER JOIN dispositivos d ON t.dispositivo_id = d.id
                INNER JOIN clientes c ON t.cliente_id = c.id
                INNER JOIN users u ON c.user_id = u.id
                INNER JOIN estados_tickets e ON t.estado_id = e.id
                INNER JOIN tecnicos tec ON t.tecnico_id = tec.id
                LEFT JOIN users us ON tec.user_id = u.id";
        return $this->conn->query($sql);
    }

    public function ver($id)
    {
        $sql = "SELECT * FROM tickets WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function actualizar($id, $descripcion_falla)
    {
        $sql = "UPDATE tickets SET descripcion_falla = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $descripcion_falla, $id);
        return $stmt->execute();
    }

    public function eliminar($id)
    {
        $sql = "DELETE FROM tickets WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
    public function obtenerDispositivosPorCliente($cliente_id)
    {
        $sql = "SELECT d.id, d.marca, d.modelo, d.descripcion_falla 
            FROM dispositivos d
            INNER JOIN users u ON d.user_id = u.id
            WHERE d.user_id = ?";
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
}
