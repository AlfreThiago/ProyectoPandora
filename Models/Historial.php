<?php

class Historial
{
    private $connection;

    public function __construct($dbConnection)
    {
        $this->connection = $dbConnection;
    }

    public function agregarAccion($accion, $detalle)
    {
        $stmt = $this->connection->prepare("INSERT INTO historial (acciones, detalles, fecha) VALUES (?, ?, NOW())");
        if ($stmt) {
            $stmt->bind_param("ss", $accion, $detalle);
            return $stmt->execute();
        }
        return false;
    }

    public function obtenerHistorial()
    {
        $stmt = $this->connection->prepare("SELECT * FROM historial ORDER BY fecha DESC");
        if ($stmt) {
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }
}
