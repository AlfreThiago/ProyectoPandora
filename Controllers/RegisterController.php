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
            header('Location: /ProyectoPandora/Public/index.php?route=Auth/Login');
            exit;
        } else {
            include_once __DIR__ . '/../Views/Auth/Register.php';
        }
    }
    public function RegisterAdminPortal()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $controllerRegister = new RegisterController();
            $controllerRegister->RegisterUser($username, $email, $password);
            header('Location: /ProyectoPandora/Public/index.php?route=Dash/Admin');
            exit;
        } else {
            include_once __DIR__ . '/../Core/Requirements.php';
            $user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
            if (!$user || $user['role'] !== 'Administrador') {
                header('Location: /ProyectoPandora/Public/index.php?route=Auth/Login');
                exit;
            }
            include_once __DIR__ . '/../Views/Shared/AdminHeader.php';
            include_once __DIR__ . '/../Views/Auth/RegisterAdminPortal.php';
        }
    }

    public function RegisterUser($username, $email, $password)
    {
        $db = new Database();
        $db->connectDatabase();
        $userModel = new UserModel($db->getConnection());

        // Verifica si el email ya existe
        $existingUser = $userModel->findByEmail($email);
        if ($existingUser) {
            // Puedes mostrar un mensaje o redirigir con error
            header('Location: /ProyectoPandora/Public/index.php?route=Register/Register&error=EmailYaRegistrado');
            exit;
        }

        $role = ($email === 'admin@admin.com') ? 'Administrador' : 'Cliente';

        if ($userModel->createUser($username, $email, $password, $role)) {
            return "User registered successfully.";
        } else {
            return "Error registering user.";
        }
    }
}
