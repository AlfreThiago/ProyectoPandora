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
        $stmt = $this->connection->prepare("INSERT INTO categorias (name) VALUES (?)");
        if ($stmt) {
            $stmt->bind_param("s", $nombreCategoria);
            return $stmt->execute();
        }
        return false;
    }
    public function updateCategory($id, $nombreCategoria)
    {
        $stmt = $this->connection->prepare("UPDATE categorias SET name = ? WHERE id = ?");
        if ($stmt) {
            $stmt->bind_param("si", $nombreCategoria, $id);
            return $stmt->execute();
        }
        return false;
    }
    public function deleteCategory($id)
    {
        $stmt = $this->connection->prepare("DELETE FROM categorias WHERE id = ?");
        if ($stmt) {
            $stmt->bind_param("i", $id);
            return $stmt->execute();
        }
        return false;
    }
    public function getAllCategories()
    {
        $stmt = $this->connection->prepare("SELECT * FROM categorias");
        if ($stmt) {
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }
    public function getCategoryById($id)
    {
        $stmt = $this->connection->prepare("SELECT * FROM categorias WHERE id = ?");
        if ($stmt) {
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_assoc();
        }
        return [];
    }
}
