<?php
//"require_once" es una función que incluye y evalúa el contenido de un archivo especificado. La diferencia clave con require() es que require_once() verifica si el archivo ya ha sido incluido en la ejecución actual del script, y si es así, no lo incluye nuevamente. Esto ayuda a prevenir errores causados por la inclusión duplicada de archivos, como la redefinición de funciones o variables. 
require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../Core/Database.php';

//es un controlador que maneja el registro de nuevos usuarios en la aplicación.
class RegisterController
{
    // Maneja el registro de un nuevo usuario
    // Si el registro es exitoso, redirige al usuario a la página de inicio de sesión
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

    // Maneja el registro de un nuevo usuario desde el portal de administración
    // Si el registro es exitoso, redirige al usuario a la página de administración
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
            header('Location: /ProyectoPandora/Public/index.php?route=Dash/RegisterAdminPortal');
        }
    }

    // Registra un nuevo usuario en la base de datos
    // Si el correo electrónico ya está registrado, redirige al usuario a la página de registro con un mensaje de error o al portal de administración si tu rol es administrador con el mismo mensaje de error
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
}
