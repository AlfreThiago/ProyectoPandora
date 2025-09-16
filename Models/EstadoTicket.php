<?php
class EstadoTicketModel
{
    private $connection;

    public function __construct($dbConnection)
    {
        $this->connection = $dbConnection;
    }

    public function obtenerTodos()
    {
        $stmt = $this->connection->prepare("SELECT * FROM estados_tickets ORDER BY id ASC");
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function obtenerPorId($id)
    {
        $stmt = $this->connection->prepare("SELECT * FROM estados_tickets WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function crear($name)
    {
        $stmt = $this->connection->prepare("INSERT INTO estados_tickets (name) VALUES (?)");
        $stmt->bind_param("s", $name);
        return $stmt->execute();
    }

    public function updateEstado($id, $name)
    {
        $sql = "UPDATE estados_tickets SET name = ? WHERE id = ?";
        $stmt = $this->connection->prepare($sql);
        if ($stmt === false) {
            die("Error en prepare: " . $this->connection->error);
        }
        $stmt->bind_param("si", $name, $id);
        return $stmt->execute();
    }

    public function getById($id)
    {
        $sql = "SELECT * FROM estados_tickets WHERE id = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function eliminar($id)
    {
        $stmt = $this->connection->prepare("DELETE FROM estados_tickets WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function getAllEstados()
    {
        $result = $this->connection->query("SELECT * FROM estados_tickets");
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }
}
