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

    // Listado con filtros opcionales por categoría y búsqueda por nombre
    public function listarFiltrado($categoria_id = null, $buscar = '', $limit = null, $offset = null, $sort = 'i.id', $dir = 'DESC')
    {
        $sql = "SELECT i.id, c.name AS categoria, i.name_item, i.valor_unitario, i.foto_item, i.stock_actual, i.stock_minimo
                FROM inventarios i
                INNER JOIN categorias_inventario c ON i.categoria_id = c.id";
        $conds = [];
        $params = [];
        $types = '';
        if ($categoria_id) {
            $conds[] = 'i.categoria_id = ?';
            $types .= 'i';
            $params[] = (int)$categoria_id;
        }
        if ($buscar !== '') {
            $conds[] = 'i.name_item LIKE ?';
            $types .= 's';
            $params[] = '%' . $buscar . '%';
        }
        if ($conds) {
            $sql .= ' WHERE ' . implode(' AND ', $conds);
        }
        $sql .= " ORDER BY $sort $dir";
        if ($limit !== null && $offset !== null) {
            $sql .= ' LIMIT ? OFFSET ?';
            $types .= 'ii';
            $params[] = (int)$limit;
            $params[] = (int)$offset;
        }

        if ($types) {
            $stmt = $this->conn->prepare($sql);
            if (!$stmt) return [];
            // Convertir params a referencias para bind_param
            $bindParams = [];
            $bindParams[] = & $types;
            foreach ($params as $k => $v) {
                $bindParams[] = & $params[$k];
            }
            call_user_func_array([$stmt, 'bind_param'], $bindParams);
            $stmt->execute();
            $res = $stmt->get_result();
        } else {
            $res = $this->conn->query($sql);
        }
        $data = [];
        if ($res) {
            while ($row = $res->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }

    public function contarFiltrado($categoria_id = null, $buscar = '')
    {
        $sql = "SELECT COUNT(*) AS total
                FROM inventarios i
                INNER JOIN categorias_inventario c ON i.categoria_id = c.id";
        $conds = [];
        $params = [];
        $types = '';
        if ($categoria_id) {
            $conds[] = 'i.categoria_id = ?';
            $types .= 'i';
            $params[] = (int)$categoria_id;
        }
        if ($buscar !== '') {
            $conds[] = 'i.name_item LIKE ?';
            $types .= 's';
            $params[] = '%' . $buscar . '%';
        }
        if ($conds) {
            $sql .= ' WHERE ' . implode(' AND ', $conds);
        }
        if ($types) {
            $stmt = $this->conn->prepare($sql);
            if (!$stmt) return 0;
            $bindParams = [];
            $bindParams[] = & $types;
            foreach ($params as $k => $v) {
                $bindParams[] = & $params[$k];
            }
            call_user_func_array([$stmt, 'bind_param'], $bindParams);
            $stmt->execute();
            $res = $stmt->get_result();
        } else {
            $res = $this->conn->query($sql);
        }
        if ($res && ($row = $res->fetch_assoc())) {
            return (int)$row['total'];
        }
        return 0;
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

    // Buscar un item por categoría y nombre (para controlar duplicados lógicos)
    public function findByCategoryAndName($categoria_id, $name_item)
    {
        $sql = "SELECT * FROM inventarios WHERE categoria_id = ? AND name_item = ? LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("is", $categoria_id, $name_item);
            $stmt->execute();
            $res = $stmt->get_result();
            return $res->fetch_assoc();
        }
        return null;
    }

    // Sumar cantidad al stock actual de un item existente
    public function sumarStock($id, $cantidad)
    {
        $sql = "UPDATE inventarios SET stock_actual = stock_actual + ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("ii", $cantidad, $id);
            return $stmt->execute();
        }
        return false;
    }

    // Reducir stock si hay suficiente cantidad
    public function reducirStock($id, $cantidad)
    {
        // Verificar stock suficiente
        $stmtSel = $this->conn->prepare("SELECT stock_actual FROM inventarios WHERE id = ?");
        if (!$stmtSel) return false;
        $stmtSel->bind_param("i", $id);
        $stmtSel->execute();
        $res = $stmtSel->get_result();
        $row = $res->fetch_assoc();
        if (!$row || (int)$row['stock_actual'] < (int)$cantidad) {
            return false;
        }
        $stmtUpd = $this->conn->prepare("UPDATE inventarios SET stock_actual = stock_actual - ? WHERE id = ?");
        if ($stmtUpd) {
            $stmtUpd->bind_param("ii", $cantidad, $id);
            return $stmtUpd->execute();
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