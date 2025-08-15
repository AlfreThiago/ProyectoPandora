<?php

class DashController
{
    public function AdminDash()
    {
        require_once __DIR__ . '/../Core/Auth.php';
        Auth::checkRole('Administrador');
        include_once __DIR__ . '/../Views/Includes/Header.php';
        include_once __DIR__ . '/../Views/Dashboard/AdminDash.php';
        include_once __DIR__ . '/../Views/Includes/Footer.php';
    }
    public function TablaDispositivos()
    {
        require_once __DIR__ . '/../Core/Auth.php';
        Auth::checkRole('Administrador');
        include_once __DIR__ . '/../Views/Includes/Header.php';
        include_once __DIR__ . '/../Views/Dashboard/AdminDash/TablaDispositivos.php';
        include_once __DIR__ . '/../Views/Includes/Footer.php';
    }
    public function TablaCliente()
    {
        require_once __DIR__ . '/../Core/Auth.php';
        Auth::checkRole(['Administrador', 'Supervisor']);
        include_once __DIR__ . '/../Views/Includes/Header.php';
        include_once __DIR__ . '/../Views/Dashboard/AdminDash/TablaCliente.php';
        include_once __DIR__ . '/../Views/Includes/Footer.php';
    }
    public function TablaTecnico()
    {
        require_once __DIR__ . '/../Core/Auth.php';
        Auth::checkRole(['Administrador', 'Supervisor']);
        include_once __DIR__ . '/../Views/Includes/Header.php';
        include_once __DIR__ . '/../Views/Dashboard/AdminDash/TablaTecnico.php';
        include_once __DIR__ . '/../Views/Includes/Footer.php';
    }
    public function TablaSupervisor()
    {
        require_once __DIR__ . '/../Core/Auth.php';
        Auth::checkRole('Administrador');
        include_once __DIR__ . '/../Views/Includes/Header.php';
        include_once __DIR__ . '/../Views/Dashboard/AdminDash/TablaSupervisor.php';
        include_once __DIR__ . '/../Views/Includes/Footer.php';
    }
    public function TablaAdmin()
    {
        require_once __DIR__ . '/../Core/Auth.php';
        Auth::checkRole('Administrador');
        include_once __DIR__ . '/../Views/Includes/Header.php';
        include_once __DIR__ . '/../Views/Dashboard/AdminDash/TablaAdmin.php';
        include_once __DIR__ . '/../Views/Includes/Footer.php';
    }
    public function SupervisorDash()
    {
        require_once __DIR__ . '/../Core/Auth.php';
        Auth::checkRole('Supervisor');
        include_once __DIR__ . '/../Views/Includes/Header.php';
        include_once __DIR__ . '/../Views/Dashboard/SupervisorDash.php';
        include_once __DIR__ . '/../Views/Includes/Footer.php';
    }
    public function TecnicoDash()
    {
        require_once __DIR__ . '/../Core/Auth.php';
        Auth::checkRole('Tecnico');
        include_once __DIR__ . '/../Views/Includes/Header.php';
        include_once __DIR__ . '/../Views/Dashboard/TecnicoDash.php';
        include_once __DIR__ . '/../Views/Includes/Footer.php';
    }
    public function ClienteDash()
    {
        require_once __DIR__ . '/../Core/Auth.php';
        Auth::checkRole('Cliente');
        include_once __DIR__ . '/../Views/Includes/Header.php';
        include_once __DIR__ . '/../Views/Dashboard/ClienteDash.php';
        include_once __DIR__ . '/../Views/Includes/Footer.php';
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
        include_once __DIR__ . '/../Views/Includes/Footer.php';
    }
    public function RegisterDash()
    {
        include_once __DIR__ . '/../Views/Includes/Header.php';
        include_once __DIR__ . '/../Views/Auth/Register.php';
        include_once __DIR__ . '/../Views/Includes/Footer.php';
    }
    public function RegisterAdminPortal()
    {
        require_once __DIR__ . '/../Core/Auth.php';
        Auth::checkRole('Administrador');
        include_once __DIR__ . '/../Views/Includes/Header.php';
        include_once __DIR__ . '/../Views/Auth/RegisterAdminPortal.php';
        include_once __DIR__ . '/../Views/Includes/Footer.php';
    }
    public function DeviceDash()
    {
        require_once __DIR__ . '/../Core/Auth.php';
        Auth::checkRole(['Administrador', 'Cliente', 'Tecnico', 'Supervisor']);
        include_once __DIR__ . '/../Views/Includes/Header.php';
        include_once __DIR__ . '/../Views/Dashboard/DeviceDash.php';
        include_once __DIR__ . '/../Views/Includes/Footer.php';
    }
    public function CategoryDash()
    {
        require_once __DIR__ . '/../Core/Auth.php';
        Auth::checkRole('Administrador');
        include_once __DIR__ . '/../Views/Includes/Header.php';
        include_once __DIR__ . '/../Views/Dashboard/CategoryD.php';
        include_once __DIR__ . '/../Views/Includes/Footer.php';
    }
}
