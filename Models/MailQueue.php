<?php

class MailQueueModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
        $this->ensureTable();
    }

    private function ensureTable() {
        $sql = "CREATE TABLE IF NOT EXISTS mail_queue (
            id INT AUTO_INCREMENT PRIMARY KEY,
            recipient VARCHAR(150) NOT NULL,
            subject VARCHAR(200) NOT NULL,
            body TEXT NOT NULL,
            status ENUM('PENDING','SENT','FAILED') NOT NULL DEFAULT 'PENDING',
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            sent_at DATETIME NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
        $this->conn->query($sql);
    }

    public function enqueue($recipient, $subject, $body) {
        $stmt = $this->conn->prepare("INSERT INTO mail_queue (recipient, subject, body) VALUES (?,?,?)");
        if (!$stmt) return false;
        $stmt->bind_param("sss", $recipient, $subject, $body);
        return $stmt->execute();
    }
}

?>