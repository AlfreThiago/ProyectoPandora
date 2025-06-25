<?php
require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../Core/Database.php';

class AuthController
{
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $db = new Database();
            $db->conectDatabase();
            $userModel = new UserModel($db->getConnection());

            $user = $userModel->findByEmail($email);
            if ($user && password_verify($password, $user['password'])) {
                // Start session and set user data
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                header('Location: ../Views/Dashboard/dashboard.php');
                exit;
            } else {
                echo "Invalid email or password.";
            }
        } else {
            include 'Views/Auth/Login.php';
        }
    }

    public function logout()
    {
        session_start();
        session_destroy();
        header('Location: ../Views/Auth/Login.php');
        exit;
    }
}
