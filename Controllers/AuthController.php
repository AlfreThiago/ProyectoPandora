<?php
//__DIR__ es una constante mágica que devuelve el directorio donde se encuentra el archivo actual. Es equivalente a dirname(__FILE__), pero se considera más legible y preferible para obtener la ruta del directorio del script que se está ejecutando o del archivo incluido. 
require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../Core/Database.php';

// es un modelo o plantilla que define las propiedades (variables) y métodos (funciones) de un objeto. Es la base de la programación orientada a objetos (POO) en PHP, permitiendo agrupar datos y comportamientos relacionados para crear instancias de objetos. 
class AuthController
{

    // Maneja el inicio de sesión de un usuario
    // Hace la redirecion a su respectiva pagina segun su rol
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

    // se encarga de cerrar la sesión del usuario
    // y redirigirlo a la página de inicio
    public function Logout()
    {
        session_start();
        session_unset();
        session_destroy();
        header('Location: /ProyectoPandora/Public/index.php?route=Dash/Home');
        exit;
    }
}
