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
}
