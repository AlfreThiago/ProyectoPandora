<?php

require_once __DIR__ . '/../Core/Database.php';
require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../Core/Auth.php';
require_once __DIR__ . '/../Controllers/HistorialController.php';

class AdminController
{

    public function changeRole()
    {
        Auth::checkRole('Administrador');

        $userId = $_POST['user_id'];
        $newRole = $_POST['newRole'];

        $db = new Database();
        $db->connectDatabase();
        $userModel = new UserModel($db->getConnection());
        $userModel->updateRole($userId, $newRole);
        header('Location: /ProyectoPandora/Public/index.php?route=Dash/Admin');
        exit;
    }

    public function EditUser()
    {
        Auth::checkRole('Administrador');

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

    public function DeleteUser()
    {
        Auth::checkRole('Administrador');

        $userId = $_GET['id'];
        $db = new Database();
        $db->connectDatabase();
        $userModel = new UserModel($db->getConnection());
        $userModel->deleteUser($userId);
        header('Location: /ProyectoPandora/Public/index.php?route=Dash/Admin');
        exit;
    }
}
