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
            header('Location: /ProyectoPandora/Public/index.php?route=Dash/Register');
        }
    }

    public function RegisterAdminPortal()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $role = $_POST['role'] ?? 'Cliente';

            $controllerRegister = new RegisterController();
            $controllerRegister->RegisterUserWithRole($username, $email, $password, $role); // Usamos la nueva función
            header('Location: /ProyectoPandora/Public/index.php?route=Dash/Admin');
            exit;
        } else {
            header('Location: /ProyectoPandora/Public/index.php?route=Dash/RegisterAdminPortal');
        }
    }
    function RegisterUser($username, $email, $password)
    {
        $db = new Database();
        $db->connectDatabase();
        $userModel = new UserModel($db->getConnection());
        $existingUser = $userModel->findByEmail($email);
        if ($existingUser) {
            $isAdmin = isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], 'RegisterAdminPortal') !== false;
            $route = $isAdmin ? 'Register/RegisterAdminPortal' : 'Register/Register';
            header("Location: /ProyectoPandora/Public/index.php?route=$route&error=EmailYaRegistrado");
            exit;
        }

        $role = ($email === 'admin@admin.com') ? 'Administrador' : 'Cliente';

        if ($userModel->createUser($username, $email, $password, $role)) {
            return "User registered successfully.";
        } else {
            return "Error registering user.";
        }
    }
    public function RegisterUserWithRole($username, $email, $password, $role)
    {
        $db = new Database();
        $db->connectDatabase();
        $userModel = new UserModel($db->getConnection());

        $existingUser = $userModel->findByEmail($email);
        if ($existingUser) {
            $isAdmin = isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], 'RegisterAdminPortal') !== false;
            $route = $isAdmin ? 'Register/RegisterAdminPortal' : 'Register/Register';
            header("Location: /ProyectoPandora/Public/index.php?route=$route&error=EmailYaRegistrado");
            exit;
        }

        if ($userModel->createUser($username, $email, $password, $role)) {
            return "Usuario registrado correctamente con rol: $role";
        } else {
            return "Error al registrar usuario.";
        }
    }
}
