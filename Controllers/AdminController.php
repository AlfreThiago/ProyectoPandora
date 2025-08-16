<?php

require_once __DIR__ . '/../Core/Database.php';
require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../Core/Auth.php';
require_once __DIR__ . '/../Controllers/HistorialController.php';

class AdminController
{
    private $historialController;

    public function __construct()
    {
        $this->historialController = new HistorialController();
    }

    public function changeRole()
    {
        Auth::checkRole('Administrador');

        $userId = $_POST['user_id'];
        $newRole = $_POST['newRole'];

        $db = new Database();
        $db->connectDatabase();
        $userModel = new UserModel($db->getConnection());
        $userModel->updateRole($userId, $newRole);

        // Guardar en historial
        $admin = Auth::user();
        $accion = "Cambio de rol";
        $detalle = "El administrador {$admin['name']} cambió el rol del usuario con ID {$userId} a {$newRole}.";
        $this->historialController->agregarAccion($accion, $detalle);

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

            // Guardar en historial
            $admin = Auth::user();
            $accion = "Edición de usuario";
            $detalle = "El administrador {$admin['name']} editó el usuario con ID {$userId} (Nuevo nombre: {$name}, Nuevo rol: {$role}).";
            $this->historialController->agregarAccion($accion, $detalle);

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

        // Guardar en historial
        $admin = Auth::user();
        $accion = "Eliminación de usuario";
        $detalle = "El administrador {$admin['name']} eliminó el usuario con ID {$userId}.";
        $this->historialController->agregarAccion($accion, $detalle);

        header('Location: /ProyectoPandora/Public/index.php?route=Dash/Admin');
        exit;
    }
}
