<?php
require_once __DIR__ . '../../Core/Database.php';
class UserModel
{

    private $connection;

    public function __construct($dbConnection)
    {
        $this->connection = $dbConnection;
    }

    public function createUser($username, $email, $password, $role = 'Cliente')
    {
        $stmt = $this->connection->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
        if ($stmt) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt->bind_param("ssss", $username, $email, $hashed_password, $role);
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
    public function updateRole($userId, $newRole)
    {
        $stmt = $this->connection->prepare("UPDATE users SET role = ? WHERE id = ?");
        if ($stmt) {
            $stmt->bind_param("si", $newRole, $userId);
            return $stmt->execute();
        }
        return false;
    }
    public function getAllUsers()
    {
        $stmt = $this->connection->prepare("SELECT * FROM users");
        if ($stmt) {
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }
    public function findById($userId)
    {
        $stmt = $this->connection->prepare("SELECT * FROM users WHERE id = ?");
        if ($stmt) {
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_assoc();
        }
        return null;
    }
    public function updateUser($userId, $name, $email, $role)
    {
        $stmt = $this->connection->prepare("UPDATE users SET name = ?, email = ?, role = ? WHERE id = ?");
        if ($stmt) {
            $stmt->bind_param("sssi", $name, $email, $role, $userId);
            return $stmt->execute();
        }
        return false;
    }
    public function deleteUser($userId)
    {
        $stmt = $this->connection->prepare("DELETE FROM users WHERE id = ?");
        if ($stmt) {
            $stmt->bind_param("i", $userId);
            return $stmt->execute();
        }
        return false;
    }
}
