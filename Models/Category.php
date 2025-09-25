<?php
require_once __DIR__ . '/../Core/Database.php';
class CategoryModel
{
    private $conn;
    public function __construct($dbConnection)
    {
        $this->conn = $dbConnection;
    }

    
    public function createCategory($nombreCategoria)
    {
        $stmt = $this->conn->prepare("INSERT INTO categorias (name) VALUES (?)");
        if ($stmt) {
            $stmt->bind_param("s", $nombreCategoria);
            return $stmt->execute();
        }
        return false;
    }
    public function updateCategory($id, $nombreCategoria)
    {
        $stmt = $this->conn->prepare("UPDATE categorias SET name = ? WHERE id = ?");
        if ($stmt) {
            $stmt->bind_param("si", $nombreCategoria, $id);
            return $stmt->execute();
        }
        return false;
    }
    public function deleteCategory($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM categorias WHERE id = ?");
        if ($stmt) {
            $stmt->bind_param("i", $id);
            return $stmt->execute();
        }
        return false;
    }
    public function getAllCategories()
    {
        $stmt = $this->conn->prepare("SELECT * FROM categorias");
        if ($stmt) {
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }
    public function getCategoryById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM categorias WHERE id = ?");
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
        $stmt = $this->conn->prepare("SELECT * FROM categorias WHERE id = ?");
        if ($stmt) {
            $stmt->bind_param("i", $categoriaId);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_assoc();
        }
        return false;
    }

    
    public function crearInventarioCategory($name)
    {
        $stmt = $this->conn->prepare("INSERT INTO categorias_inventario (name) VALUES (?)");
        if ($stmt) {
            $stmt->bind_param("s", $name);
            return $stmt->execute();
        }
        return false;
    }
    public function findInventarioCategoryById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM categorias_inventario WHERE id = ?");
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
        $stmt = $this->conn->prepare("UPDATE categorias_inventario SET name = ? WHERE id = ?");
        if ($stmt) {
            $stmt->bind_param("si", $name, $id);
            return $stmt->execute();
        }
        return false;
    }
    public function eliminarCategory($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM categorias_inventario WHERE id = ?");
        if ($stmt) {
            $stmt->bind_param("i", $id);
            return $stmt->execute();
        }
        return false;
    }
    public function getAllInventarioCategories()
    {
        $result = $this->conn->query("SELECT * FROM categorias_inventario");
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }
    public function crearCategoria($name)
    {
        $sql = "INSERT INTO categorias_inventario (name) VALUES (?)";
        $stmt = $this->conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("s", $name);
            return $stmt->execute();
        }
        return false;
    }
    public function eliminarCategoria($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM categorias_inventario WHERE id = ?");
        if ($stmt) {
            $stmt->bind_param("i", $id);
            return $stmt->execute();
        }
        return false;
    }
    public function obtenerCategoryPorId($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM categorias_inventario WHERE id = ?");
        if ($stmt) {
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_assoc();
        }
        return null;
    }

    public function actualizarCategory($id, $name)
    {
        $stmt = $this->conn->prepare("UPDATE categorias_inventario SET name = ? WHERE id = ?");
        if ($stmt) {
            $stmt->bind_param("si", $name, $id);
            return $stmt->execute();
        }
        return false;
    }
}
