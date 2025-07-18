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
            if ($stmt->execute()) {
                $userId = $this->connection->insert_id;
                // Insertar en la tabla correspondiente según el rol
                switch ($role) {
                    case 'Cliente':
                        $this->connection->prepare("INSERT INTO clientes (user_id) VALUES (?)")->bind_param("i", $userId)->execute();
                        break;
                    case 'Tecnico':
                        $this->connection->prepare("INSERT INTO tecnicos (user_id, disponibilidad) VALUES (?, 'Disponible')")->bind_param("i", $userId)->execute();
                        break;
                    case 'Supervisor':
                        $this->connection->prepare("INSERT INTO supervisores (user_id) VALUES (?)")->bind_param("i", $userId)->execute();
                        break;
                    case 'Administrador':
                        $this->connection->prepare("INSERT INTO administradores (user_id) VALUES (?)")->bind_param("i", $userId)->execute();
                        break;
                }

                return true;
            }
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
    public function getAllClientes()
    {
        $sql = "SELECT u.id, u.name, u.email, u.role, c.telefono, c.direccion, u.created_at
            FROM users u
            INNER JOIN clientes c ON u.id = c.user_id";
        $result = $this->connection->query($sql);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function getAllTecnicos()
    {
        $sql = "SELECT u.id, u.name, u.email, u.role,t.disponibilidad, t.especialidad, u.created_at
            FROM users u
            INNER JOIN tecnicos t ON u.id = t.user_id";
        $result = $this->connection->query($sql);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function getAllSupervisores()
    {
        $sql = "SELECT u.id, u.name, u.email, u.role, u.created_at
            FROM users u
            INNER JOIN supervisores s ON u.id = s.user_id";
        $result = $this->connection->query($sql);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function getAllAdministradores()
    {
        $sql = "SELECT u.id, u.name, u.email, u.role, u.created_at
            FROM users u
            INNER JOIN administradores a ON u.id = a.user_id";
        $result = $this->connection->query($sql);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
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
