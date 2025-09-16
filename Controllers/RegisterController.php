<?php
require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../Core/Database.php';
require_once __DIR__ . '/../Core/Auth.php';
require_once __DIR__ . '/../Controllers/HistorialController.php';

class RegisterController
{
    private $historialController;

    public function __construct()
    {
        $this->historialController = new HistorialController();
    }

    public function Register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $result = $this->RegisterUser($username, $email, $password);
            // Guardar en historial
            $accion = "Registro de usuario";
            $detalle = "Se registró el usuario {$username} con email {$email}. Resultado: {$result}";
            $this->historialController->agregarAccion($accion, $detalle);

            header('Location: /ProyectoPandora/Public/index.php?route=Auth/Login');
            exit;
        } else {
            include_once __DIR__ . '/../Views/Auth/Register.php';
        }
    }

    public function RegisterAdmin()
    {
        $user = Auth::user();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $role = $_POST['role'] ?? 'Cliente';

            $result = $this->RegisterUserWithRole($username, $email, $password, $role);

            $accion = "Registro de usuario por admin";
            $detalle = "El administrador registró el usuario {$username} con email {$email} y rol {$role}. Resultado: {$result}";
            $this->historialController->agregarAccion($accion, $detalle);

            header('Location: /ProyectoPandora/Public/index.php?route=Admin/ListarUsers');
            exit;
        } else {
            include_once __DIR__ . '/../Views/Admin/Register.php';
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
