<?php
require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../Core/Database.php';
require_once __DIR__ . '/../Core/Auth.php';
require_once __DIR__ . '/../Controllers/HistorialController.php';

class AuthController
{
    private $historialController;

    public function __construct()
    {
        $this->historialController = new HistorialController();
    }

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
                Auth::login($user);
                header('Location: /ProyectoPandora/Public/index.php?route=Default/Index');
                exit;
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
        Auth::logout();
        header('Location: /ProyectoPandora/Public/index.php?route=Default/Index');
        exit;
    }
}
