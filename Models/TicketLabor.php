<?php

class TicketLaborModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
        $this->ensureTable();
    }

    private function ensureTable() {
        $sql = "CREATE TABLE IF NOT EXISTS ticket_labor (
            ticket_id INT PRIMARY KEY,
            tecnico_id INT NOT NULL,
            labor_amount DECIMAL(10,2) NOT NULL DEFAULT 0,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (ticket_id) REFERENCES tickets(id) ON DELETE CASCADE,
            FOREIGN KEY (tecnico_id) REFERENCES tecnicos(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
        $this->conn->query($sql);
    }

    public function getByTicket($ticket_id) {
        $stmt = $this->conn->prepare("SELECT * FROM ticket_labor WHERE ticket_id = ? LIMIT 1");
        if (!$stmt) return null;
        $stmt->bind_param("i", $ticket_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function upsert($ticket_id, $tecnico_id, $labor_amount) {
        $exists = $this->getByTicket($ticket_id);
        if ($exists) {
            $stmt = $this->conn->prepare("UPDATE ticket_labor SET labor_amount = ?, tecnico_id = ? WHERE ticket_id = ?");
            if (!$stmt) return false;
            $stmt->bind_param("dii", $labor_amount, $tecnico_id, $ticket_id);
            return $stmt->execute();
        }
        $stmt = $this->conn->prepare("INSERT INTO ticket_labor (ticket_id, tecnico_id, labor_amount) VALUES (?,?,?)");
        if (!$stmt) return false;
        $stmt->bind_param("iid", $ticket_id, $tecnico_id, $labor_amount);
        return $stmt->execute();
    }
}

?>
