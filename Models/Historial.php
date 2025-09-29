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

    
    public function buscarHistorial($q = '', $tipo = '', $desde = '', $hasta = '', $page = 1, $perPage = 20)
    {
        $conds = [];
        $params = [];
        $types = '';

        if ($q !== '') {
            $conds[] = '(acciones LIKE ? OR detalles LIKE ?)';
            $like = '%' . $q . '%';
            $params[] = $like; $params[] = $like; $types .= 'ss';
        }
        if ($tipo !== '') {
            $conds[] = 'LOWER(acciones) LIKE ?';
            $params[] = '%' . strtolower($tipo) . '%';
            $types .= 's';
        }
        if ($desde !== '') {
            $conds[] = 'DATE(fecha) >= ?';
            $params[] = $desde; $types .= 's';
        }
        if ($hasta !== '') {
            $conds[] = 'DATE(fecha) <= ?';
            $params[] = $hasta; $types .= 's';
        }

        $where = empty($conds) ? '' : ('WHERE ' . implode(' AND ', $conds));

        
        $sqlCount = "SELECT COUNT(*) AS c FROM historial $where";
        $stmtC = $this->connection->prepare($sqlCount);
        if ($stmtC) {
            if ($types !== '') {
                $stmtC->bind_param($types, ...$params);
            }
            $stmtC->execute();
            $res = $stmtC->get_result()->fetch_assoc();
            $total = (int)($res['c'] ?? 0);
        } else {
            $total = 0;
        }

        $page = max(1, (int)$page);
        $perPage = max(1, min(200, (int)$perPage));
        $offset = ($page - 1) * $perPage;

        
        $sql = "SELECT * FROM historial $where ORDER BY fecha DESC LIMIT ? OFFSET ?";
        $stmt = $this->connection->prepare($sql);
        if (!$stmt) {
            return ['data' => [], 'total' => 0, 'page' => $page, 'perPage' => $perPage];
        }

        if ($types !== '') {
            $typesAll = $types . 'ii';
            $paramsAll = array_merge($params, [ $perPage, $offset ]);
            
            $stmt->bind_param($typesAll, ...$paramsAll);
        } else {
            $stmt->bind_param('ii', $perPage, $offset);
        }

        $data = [];
        if ($stmt->execute()) {
            $data = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        }
        return ['data' => $data, 'total' => $total, 'page' => $page, 'perPage' => $perPage];
    }
}
