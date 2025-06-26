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

            echo "Estoy en login() de AuthController<br>";
            var_dump($_POST);

            $user = $userModel->findByEmail($email);
            if ($user && password_verify($password, $user['password'])) {
                session_start();
                $_SESSION['user'] = $user; // Guarda el usuario en la sesión
                header('Location: /ProyectoPandora/Views/Dashboard/dashboard.php');
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
