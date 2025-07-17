<?php
require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../Core/Database.php';

class AuthController
{
    public function Login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $db = new Database();
            $db->connectDatabase();
            $userModel = new UserModel($db->getConnection());
            $user = $userModel->findByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
                session_start();
                $_SESSION['user'] = $user;
                if ($user['role'] === 'Administrador') {
                    header('Location: /ProyectoPandora/Public/index.php?route=Dash/Home');
                    exit;
                } elseif ($user['role'] === 'Supervisor') {
                    header('Location: /ProyectoPandora/Public/index.php?route=Dash/Home');
                    exit;
                } elseif ($user['role'] === 'Tecnico') {
                    header('Location: /ProyectoPandora/Public/index.php?route=Dash/Home');
                    exit;
                } else {
                    header('Location: /ProyectoPandora/Public/index.php?route=Dash/Home');
                    exit;
                }
            } else {
                header('Location: /ProyectoPandora/Public/index.php?route=Auth/Login');
                exit;
            }
        } else {
            include_once __DIR__ . '/../Views/Auth/Login.php';
        }
    }
    public function Logout()
    {
        session_start();
        session_unset();
        session_destroy();
        header('Location: /ProyectoPandora/Public/index.php?route=Dash/Home');
        exit;
    }
}
