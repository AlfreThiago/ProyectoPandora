<?php

class RatingModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
        $this->ensureTable();
    }

    private function ensureTable() {
        $sql = "CREATE TABLE IF NOT EXISTS ticket_ratings (
            id INT AUTO_INCREMENT PRIMARY KEY,
            ticket_id INT NOT NULL UNIQUE,
            tecnico_id INT NOT NULL,
            cliente_id INT NOT NULL,
            stars TINYINT NOT NULL,
            comment TEXT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (ticket_id) REFERENCES tickets(id) ON DELETE CASCADE,
            FOREIGN KEY (tecnico_id) REFERENCES tecnicos(id) ON DELETE CASCADE,
            FOREIGN KEY (cliente_id) REFERENCES clientes(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
        $this->conn->query($sql);
    }

    public function getByTicket($ticket_id) {
        $stmt = $this->conn->prepare("SELECT * FROM ticket_ratings WHERE ticket_id = ? LIMIT 1");
        if (!$stmt) return null;
        $stmt->bind_param("i", $ticket_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function save($ticket_id, $tecnico_id, $cliente_id, $stars, $comment = null) {
        $exists = $this->getByTicket($ticket_id);
        if ($exists) {
            $stmt = $this->conn->prepare("UPDATE ticket_ratings SET stars = ?, comment = ? WHERE ticket_id = ?");
            if (!$stmt) return false;
            $stmt->bind_param("isi", $stars, $comment, $ticket_id);
            return $stmt->execute();
        }
        $stmt = $this->conn->prepare("INSERT INTO ticket_ratings (ticket_id, tecnico_id, cliente_id, stars, comment) VALUES (?,?,?,?,?)");
        if (!$stmt) return false;
        $stmt->bind_param("iiiis", $ticket_id, $tecnico_id, $cliente_id, $stars, $comment);
        return $stmt->execute();
    }

    public function getAvgForTecnico($tecnico_id) {
        $stmt = $this->conn->prepare("SELECT AVG(stars) AS avg_stars, COUNT(*) AS total FROM ticket_ratings WHERE tecnico_id = ?");
        if (!$stmt) return [null, 0];
        $stmt->bind_param("i", $tecnico_id);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        return [$row['avg_stars'] ?? null, (int)($row['total'] ?? 0)];
    }
}

?>
