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
                Auth::login($user); // Usar método login de Auth

                // Guardar en historial
                $accion = "Login";
                $detalle = "Usuario {$user['name']} inició sesión.";
                $this->historialController->agregarAccion($accion, $detalle);

                header('Location: /ProyectoPandora/Public/index.php?route=Dash/Home');
                exit;
            } else {
                header('Location: /ProyectoPandora/Public/index.php?route=Dash/Login');
                exit;
            }
        } else {
            header('Location: /ProyectoPandora/Public/index.php?route=Dash/Login');
        }
    }

    public function Logout()
    {
        $user = Auth::user();
        if ($user) {
            // Guardar en historial
            $accion = "Logout";
            $detalle = "Usuario {$user['name']} cerró sesión.";
            $this->historialController->agregarAccion($accion, $detalle);
        }

        Auth::logout(); // Usar método logout de Auth
        header('Location: /ProyectoPandora/Public/index.php?route=Dash/Home');
        exit;
    }
}
