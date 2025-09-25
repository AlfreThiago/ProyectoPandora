<?php

class TecnicoStatsModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
        $this->ensureTable();
    }

    private function ensureTable() {
        $sql = "CREATE TABLE IF NOT EXISTS tecnico_stats (
            tecnico_id INT PRIMARY KEY,
            labor_min DECIMAL(10,2) DEFAULT 0,
            labor_max DECIMAL(10,2) DEFAULT 0,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (tecnico_id) REFERENCES tecnicos(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
        $this->conn->query($sql);
    }

    public function getByTecnico($tecnico_id) {
        $stmt = $this->conn->prepare("SELECT * FROM tecnico_stats WHERE tecnico_id = ? LIMIT 1");
        if (!$stmt) return null;
        $stmt->bind_param("i", $tecnico_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function upsert($tecnico_id, $labor_min, $labor_max) {
        $exists = $this->getByTecnico($tecnico_id);
        if ($exists) {
            $stmt = $this->conn->prepare("UPDATE tecnico_stats SET labor_min = ?, labor_max = ? WHERE tecnico_id = ?");
            if (!$stmt) return false;
            $stmt->bind_param("ddi", $labor_min, $labor_max, $tecnico_id);
            return $stmt->execute();
        }
        $stmt = $this->conn->prepare("INSERT INTO tecnico_stats (tecnico_id, labor_min, labor_max) VALUES (?,?,?)");
        if (!$stmt) return false;
        $stmt->bind_param("idd", $tecnico_id, $labor_min, $labor_max);
        return $stmt->execute();
    }
}

?>
