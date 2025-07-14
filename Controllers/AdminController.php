<?php
require_once __DIR__ . '/../Core/Auth.php';
require_once __DIR__ . '/../Core/Database.php';
require_once __DIR__ . '/../Models/User.php';

class AdminController
{
    public function changeRole()
    {
        $userId = $_POST['user_id'];
        $newRole = $_POST['newRole'];

        session_start();
        if ($_SESSION['user']['role'] !== 'Administrador') {
            header('Location: /ProyectoPandora/Public/index.php?route=Dash/Home');
            exit;
        }
        $db = new Database();
        $db->conectDatabase();
        $userModel = new UserModel($db->getConnection());
        $userModel->updateRole($userId, $newRole);
        header('Location: /ProyectoPandora/Public/index.php?route=Dash/Admin');
        exit;
    }
    public function EditUser()
    {
        session_start();
        if ($_SESSION['user']['role'] !== 'Administrador') {
            header('Location: /ProyectoPandora/Public/index.php?route=Dash/Home');
            exit;
        }

        $userId = $_GET['id'];
        $db = new Database();
        $db->conectDatabase();
        $userModel = new UserModel($db->getConnection());
        $user = $userModel->findById($userId);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $role = $_POST['role'];
            $userModel->updateUser($userId, $name, $user['email'], $role);
            header('Location: /ProyectoPandora/Public/index.php?route=Dash/Admin');
            exit;
        }
        // Hace disponible $user para la vista
        include __DIR__ . '/../Views/Dashboard/ActualizarUser.php';
    }
    public function DeleteUser()
    {
        session_start();
        if ($_SESSION['user']['role'] !== 'Administrador') {
            header('Location: /ProyectoPandora/Public/index.php?route=Dash/Home');
            exit;
        }

        $userId = $_GET['id'];
        $db = new Database();
        $db->conectDatabase();
        $userModel = new UserModel($db->getConnection());
        $userModel->deleteUser($userId);
        header('Location: /ProyectoPandora/Public/index.php?route=Dash/Admin');
        exit;
    }
}
