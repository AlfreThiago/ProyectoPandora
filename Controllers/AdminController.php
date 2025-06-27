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
            header('Location: /ProyectoPandora/Public/index.php?route=Dash/ClienteDash');
            exit;
        }
        $db = new Database();
        $db->conectDatabase();
        $userModel = new UserModel($db->getConnection());
        $userModel->updateRole($userId, $newRole);
        header('Location: /ProyectoPandora/Public/index.php?route=Dash/AdminDash');
        exit;
    }
}
