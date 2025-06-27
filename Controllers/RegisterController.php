<?php
require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../Core/Database.php';

class RegisterController
{
    public function Register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $controllerRegister = new RegisterController();
            $controllerRegister->RegisterUser($username, $email, $password);
            header('Location: /ProyectoPandora/Public/index.php?route=Dash/ClienteDash');
            exit;
        } else {
            include_once __DIR__ . '/../Views/Auth/Register.php';
        }
    }

    public function RegisterUser($username, $email, $password)
    {
        $db = new Database();
        $db->conectDatabase();
        $userModel = new UserModel($db->getConnection());

        if ($userModel->createUser($username, $email, $password)) {
            return "User registered successfully.";
        } else {
            return "Error registering user.";
        }
    }
}
