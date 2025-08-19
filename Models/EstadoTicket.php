<?php
class EstadoTicket
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

    public function eliminar($id)
    {
        $stmt = $this->connection->prepare("DELETE FROM estados_tickets WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
