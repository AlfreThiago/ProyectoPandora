<?php
require_once __DIR__ . '../../Core/Database.php';
class UserModel
{

    private $connection;

    public function __construct($dbConnection)
    {
        $this->connection = $dbConnection;
    }

    public function createUser($username, $email, $password)
    {
        $stmt = $this->connection->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        if ($stmt) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt->bind_param("sss", $username, $email, $hashed_password);
            return $stmt->execute();
        }
        return false;
    }
    public function findByEmail($email)
    {
        $stmt = $this->connection->prepare("SELECT * FROM users WHERE email = ?");
        if ($stmt) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_assoc();
        }
        return null;
    }
}
