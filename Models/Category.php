<?php

class CategoryModel
{
    private $connection;
    public function __construct($dbConnection)
    {
        $this->connection = $dbConnection;
    }
    public function createCategory($nombreCategoria)
    {
        $stmt = $this->connection->prepare("INSERT INTO categorias (nombre) VALUES (?)");
        if ($stmt) {
            $stmt->bind_param("s", $nombreCategoria);
            return $stmt->execute();
        }
        return false;
    }
    public function getCategories()
    {
        $stmt = $this->connection->prepare("SELECT * FROM categorias");
        if ($stmt) {
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }
}
