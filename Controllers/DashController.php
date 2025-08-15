<?php
//Este archivo es parte del controlador de Dash, que maneja las vistas del panel de administración y otros roles.
//Se utilzaza para mostrar diferentes dashboards según el rol del usuario autenticado.
//Ya en la propia redirecion se incluye el header correspondiente al rol del usuario.
class DashController
{
    public function AdminDash()
    {
        require_once __DIR__ . '/../Core/Auth.php';
        Auth::checkRole('Administrador');
        include_once __DIR__ . '/../Views/Includes/Header.php';
        include_once __DIR__ . '/../Views/Dashboard/AdminDash.php';
    }
    public function TablaCliente()
    {
        require_once __DIR__ . '/../Core/Auth.php';
        Auth::checkRole(['Administrador', 'Supervisor']);
        include_once __DIR__ . '/../Views/Includes/Header.php';
        include_once __DIR__ . '/../Views/Dashboard/AdminDash/TablaCliente.php';
    }
    public function TablaTecnico()
    {
        require_once __DIR__ . '/../Core/Auth.php';
        Auth::checkRole(['Administrador', 'Supervisor']);
        include_once __DIR__ . '/../Views/Includes/Header.php';
        include_once __DIR__ . '/../Views/Dashboard/AdminDash/TablaTecnico.php';
    }
    public function TablaSupervisor()
    {
        require_once __DIR__ . '/../Core/Auth.php';
        Auth::checkRole('Administrador');
        include_once __DIR__ . '/../Views/Includes/Header.php';
        include_once __DIR__ . '/../Views/Dashboard/AdminDash/TablaSupervisor.php';
    }
    public function TablaAdmin()
    {
        require_once __DIR__ . '/../Core/Auth.php';
        Auth::checkRole('Administrador');
        include_once __DIR__ . '/../Views/Includes/Header.php';
        include_once __DIR__ . '/../Views/Dashboard/AdminDash/TablaAdmin.php';
    }
    public function SupervisorDash()
    {
        require_once __DIR__ . '/../Core/Auth.php';
        Auth::checkRole('Supervisor');
        include_once __DIR__ . '/../Views/Includes/Header.php';
        include_once __DIR__ . '/../Views/Dashboard/SupervisorDash.php';
    }
    public function TecnicoDash()
    {
        require_once __DIR__ . '/../Core/Auth.php';
        Auth::checkRole('Tecnico');
        include_once __DIR__ . '/../Views/Includes/Header.php';
        include_once __DIR__ . '/../Views/Dashboard/TecnicoDash.php';
    }
    public function ClienteDash()
    {
        require_once __DIR__ . '/../Core/Auth.php';
        Auth::checkRole('Cliente');
        include_once __DIR__ . '/../Views/Includes/Header.php';
        include_once __DIR__ . '/../Views/Dashboard/ClienteDash.php';
    }
    public function HomeDash()
    {
        require_once __DIR__ . '/../Core/Auth.php';
        session_start();
        $user = $_SESSION['user'] ?? null;
        include_once __DIR__ . '/../Views/Includes/Header.php';
        include_once __DIR__ . '/../Views/Dashboard/HomeDash.php';
        include_once __DIR__ . '/../Views/Includes/Footer.php';
    }
    public function LoginDash()
    {
        include_once __DIR__ . '/../Views/Includes/Header.php';
        include_once __DIR__ . '/../Views/Auth/Login.php';
    }
    public function RegisterDash()
    {
        include_once __DIR__ . '/../Views/Includes/Header.php';
        include_once __DIR__ . '/../Views/Auth/Register.php';
    }
    public function RegisterAdminPortal()
    {
        require_once __DIR__ . '/../Core/Auth.php';
        Auth::checkRole('Administrador');
        include_once __DIR__ . '/../Views/Includes/Header.php';
        include_once __DIR__ . '/../Views/Auth/RegisterAdminPortal.php';
    }
}
