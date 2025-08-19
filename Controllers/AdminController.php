<?php

require_once __DIR__ . '/../Core/Database.php';
require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../Core/Auth.php';
require_once __DIR__ . '/../Controllers/HistorialController.php';
Auth::checkRole('Administrador');
class AdminController
{
    private $historialController;
    private $userModel;

    public function __construct()
    {
        $this->historialController = new HistorialController();
        $db = new Database();
        $db->connectDatabase();
        $this->userModel = new UserModel($db->getConnection());
    }

    public function listarUsers()
    {
        $users = $this->userModel->getAllUsers();
        include_once __DIR__ . '/../Views/Admin/ListaUser.php';
    }

    public function listarCli()
    {
        $clientes = $this->userModel->getAllClientes();
        include_once __DIR__ . '/../Views/Admin/ListaCliente.php';
    }

    public function listarTecs()
    {
        $tecnicos = $this->userModel->getAllTecnicos();
        include_once __DIR__ . '/../Views/Admin/ListaTecnico.php';
    }

    public function listarSupers()
    {
        $supervisor = $this->userModel->getAllSupervisores();
        include_once __DIR__ . '/../Views/Admin/ListaSupervisor.php';
    }

    public function listarAdmins()
    {
        $administradores = $this->userModel->getAllAdministradores();
        include_once __DIR__ . '/../Views/Admin/ListaAdmin.php';
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

        $admin = Auth::user();
        $accion = "Cambio de rol";
        $detalle = "El administrador {$admin['name']} cambió el rol del usuario con ID {$userId} a {$newRole}.";
        $this->historialController->agregarAccion($accion, $detalle);

        exit;
    }

    public function ActualizarUser()
    {
        $userId = $_GET['id'];
        $db = new Database();
        $db->connectDatabase();
        $userModel = new UserModel($db->getConnection());
        $user = $userModel->findById($userId);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $role = $_POST['role'];
            $from = $_POST['from'] ?? 'Admin/ListarUsers';

            $userModel->updateUser($userId, $name, $user['email'], $role);

            $admin = Auth::user();
            $accion = "Actualización de Usuario";
            $detalle = "El administrador {$admin['name']} editó el usuario con ID {$userId} (Nuevo nombre: {$name}, Nuevo rol: {$role}).";
            $this->historialController->agregarAccion($accion, $detalle);

            header("Location: index.php?route=$from");
            exit;
        }
        include_once __DIR__ . '/../Views/Admin/ActualizarUser.php';
    }


    public function DeleteUser()
    {
        $userId = $_GET['id'];
        $db = new Database();
        $db->connectDatabase();
        $userModel = new UserModel($db->getConnection());
        $userModel->deleteUser($userId);

        $admin = Auth::user();
        $accion = "Eliminación de usuario";
        $detalle = "El administrador {$admin['name']} eliminó el usuario con ID {$userId}.";
        $this->historialController->agregarAccion($accion, $detalle);

        header('Location: /ProyectoPandora/Public/index.php?route=Admin/ListarUsers');
        exit;
    }
}
