<?php 

class InventarioModel
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Listar todos los items de inventario
    public function listar()
    {
        $sql = "SELECT i.id, c.name AS categoria, i.name_item, i.valor_unitario, i.descripcion, i.foto_item, i.stock_actual, i.stock_minimo, i.fecha_creacion
                FROM inventarios i
                INNER JOIN categorias_inventario c ON i.categoria_id = c.id
                ORDER BY i.id DESC";
        $result = $this->conn->query($sql);
        $data = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }

    // Crear un nuevo item de inventario
    public function crear($categoria_id, $name_item, $valor_unitario, $descripcion, $foto_item, $stock_actual, $stock_minimo)
    {
        $sql = "INSERT INTO inventarios (categoria_id, name_item, valor_unitario, descripcion, foto_item, stock_actual, stock_minimo)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("isdssii", $categoria_id, $name_item, $valor_unitario, $descripcion, $foto_item, $stock_actual, $stock_minimo);
            return $stmt->execute();
        }
        return false;
    }

    // Eliminar un item de inventario
    public function eliminar($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM inventarios WHERE id = ?");
        if ($stmt) {
            $stmt->bind_param("i", $id);
            return $stmt->execute();
        }
        return false;
    }

    // Obtener un item por ID
    public function obtenerPorId($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM inventarios WHERE id = ?");
        if ($stmt) {
            $stmt->bind_param("i", $id);
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc();
        }
        return null;
    }

    // Actualizar un item de inventario
    public function actualizar($id, $categoria_id, $name_item, $valor_unitario, $descripcion, $foto_item, $stock_actual, $stock_minimo)
    {
        $sql = "UPDATE inventarios SET categoria_id=?, name_item=?, valor_unitario=?, descripcion=?, foto_item=?, stock_actual=?, stock_minimo=?
                WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("isdssiii", $categoria_id, $name_item, $valor_unitario, $descripcion, $foto_item, $stock_actual, $stock_minimo, $id);
            return $stmt->execute();
        }
        return false;
    }

    // Listar todas las categorías de inventario
    public function listarCategorias()
    {
        $sql = "SELECT id, name FROM categorias_inventario ORDER BY name";
        $result = $this->conn->query($sql);
        $data = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }
}

?>