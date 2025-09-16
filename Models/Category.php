<?php
require_once __DIR__ . '/../Core/Database.php';
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
    public function findCategoryById($categoriaId)
    {
        $stmt = $this->connection->prepare("SELECT * FROM categorias WHERE id = ?");
        if ($stmt) {
            $stmt->bind_param("i", $categoriaId);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_assoc();
        }
        return false;
    }

    // Categoria de Dispositivos ↑
    // Categoria de Inventarioes ↓
    public function crearInventarioCategory($name)
    {
        $stmt = $this->connection->prepare("INSERT INTO categorias_inventario (name) VALUES (?)");
        if ($stmt) {
            $stmt->bind_param("s", $name);
            return $stmt->execute();
        }
        return false;
    }

    public function findInventarioCategoryById($id)
    {
        $stmt = $this->connection->prepare("SELECT * FROM categorias_inventario WHERE id = ?");
        if ($stmt) {
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_assoc();
        }
        return false;
    }
    public function updateInventarioCategory($id, $name)
    {
        $stmt = $this->connection->prepare("UPDATE categorias_inventario SET name = ? WHERE id = ?");
        if ($stmt) {
            $stmt->bind_param("si", $name, $id);
            return $stmt->execute();
        }
        return false;
    }

    public function eliminarCategory($id)
    {
        $stmt = $this->connection->prepare("DELETE FROM categorias_inventario WHERE id = ?");
        if ($stmt) {
            $stmt->bind_param("i", $id);
            return $stmt->execute();
        }
        return false;
    }

    public function getAllInventarioCategories()
    {
        $result = $this->connection->query("SELECT * FROM categorias_inventario");
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }
}
