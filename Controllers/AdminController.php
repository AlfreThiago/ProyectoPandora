<?php
//__DIR__ es una constante mágica que devuelve el directorio donde se encuentra el archivo actual. Es equivalente a dirname(__FILE__), pero se considera más legible y preferible para obtener la ruta del directorio del script que se está ejecutando o del archivo incluido. 
require_once __DIR__ . '/../Core/Auth.php';
require_once __DIR__ . '/../Core/Database.php';
require_once __DIR__ . '/../Models/User.php';

// es un modelo o plantilla que define las propiedades (variables) y métodos (funciones) de un objeto. Es la base de la programación orientada a objetos (POO) en PHP, permitiendo agrupar datos y comportamientos relacionados para crear instancias de objetos. 
class AdminController
{

    // Cambia el rol de un usuario
    public function changeRole()
    {
        $userId = $_POST['user_id'];
        $newRole = $_POST['newRole'];

        // Verifica si el usuario tiene permisos de administrador antes de realizar la acción
        session_start();
        if ($_SESSION['user']['role'] !== 'Administrador') {
            header('Location: /ProyectoPandora/Public/index.php?route=Dash/Home');
            exit;
        }
        $db = new Database();
        $db->connectDatabase();
        $userModel = new UserModel($db->getConnection());
        $userModel->updateRole($userId, $newRole);
        header('Location: /ProyectoPandora/Public/index.php?route=Dash/Admin');
        exit;
    }

    // Cambia los datos de un usuario
    public function EditUser()
    {
        // Verifica si el usuario tiene permisos de administrador antes de realizar la acción
        session_start();
        if ($_SESSION['user']['role'] !== 'Administrador') {
            header('Location: /ProyectoPandora/Public/index.php?route=Dash/Home');
            exit;
        }

        $userId = $_GET['id'];
        $db = new Database();
        $db->connectDatabase();
        $userModel = new UserModel($db->getConnection());
        $user = $userModel->findById($userId);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $role = $_POST['role'];
            $userModel->updateUser($userId, $name, $user['email'], $role);
            header('Location: /ProyectoPandora/Public/index.php?route=Dash/Admin');
            exit;
        }
        include_once __DIR__ . '/../Views/Includes/Header.php';
        include_once __DIR__ . '/../Views/Dashboard/AdminDash/ActualizarUser.php';
    }

    // Elimina un usuario
    public function DeleteUser()
    {
        // Verifica si el usuario tiene permisos de administrador antes de realizar la acción  
        session_start();
        if ($_SESSION['user']['role'] !== 'Administrador') {
            header('Location: /ProyectoPandora/Public/index.php?route=Dash/Home');
            exit;
        }

        $userId = $_GET['id'];
        $db = new Database();
        $db->connectDatabase();
        $userModel = new UserModel($db->getConnection());
        $userModel->deleteUser($userId);
        header('Location: /ProyectoPandora/Public/index.php?route=Dash/Admin');
        exit;
    }
}
