<?php

class DashController
{
    public function Home()
    {
        require_once __DIR__ . '/../Core/Auth.php';
        session_start();
        $user = $_SESSION['user'] ?? null;
        include_once __DIR__ . '/../Views/Includes/Header.php';
        include_once __DIR__ . '/../Views/AllUsers/Home.php';
        include_once __DIR__ . '/../Views/Includes/Footer.php';
    }
    public function Login()
    {
        require_once __DIR__ . '/../Core/Auth.php';
        include_once __DIR__ . '/../Views/Includes/Header.php';
        include_once __DIR__ . '/../Views/Auth/Login.php';
        include_once __DIR__ . '/../Views/Includes/Footer.php';
    }
    public function Register()
    {
        require_once __DIR__ . '/../Core/Auth.php';
        include_once __DIR__ . '/../Views/Includes/Header.php';
        include_once __DIR__ . '/../Views/Auth/Register.php';
        include_once __DIR__ . '/../Views/Includes/Footer.php';
    }
    public function RegisterAdmin()
    {
        require_once __DIR__ . '/../Core/Auth.php';
        Auth::checkRole('Administrador');
        include_once __DIR__ . '/../Views/Includes/Header.php';
        include_once __DIR__ . '/../Views/Admin/Register.php';
        include_once __DIR__ . '/../Views/Includes/Footer.php';
    }
    public function CrearDevice()
    {
        require_once __DIR__ . '/../Core/Auth.php';
        Auth::checkRole(['Administrador', 'Cliente', 'Tecnico', 'Supervisor']);
        include_once __DIR__ . '/../Views/Includes/Header.php';
        include_once __DIR__ . '/../Views/Device/CrearDevice.php';
        include_once __DIR__ . '/../Views/Includes/Footer.php';
    }
    public function ActualizarDevice()
    {
        require_once __DIR__ . '/../Core/Auth.php';
        Auth::checkRole(['Administrador', 'Cliente', 'Tecnico', 'Supervisor']);
        require_once __DIR__ . '/../Views/Includes/Header.php';
        require_once __DIR__ . '/../Views/Device/ActualizarDevice.php';
        include_once __DIR__ . '/../Views/Includes/Footer.php';
    }
    public function CrearCategoriaDevice()
    {
        require_once __DIR__ . '/../Core/Auth.php';
        Auth::checkRole('Administrador');
        include_once __DIR__ . '/../Views/Includes/Header.php';
        include_once __DIR__ . '/../Views/Device/CrearCategoria.php';
        include_once __DIR__ . '/../Views/Includes/Footer.php';
    }
    public function CrearEstadoTicket()
    {
        require_once __DIR__ . '/../Core/Auth.php';
        Auth::checkRole(['Cliente', 'Tecnico', 'Supervisor', 'Administrador']);
        include_once __DIR__ . '/../Views/Includes/Header.php';
        include_once __DIR__ . '/../Views/EstadoTicket/Crear.php';
        include_once __DIR__ . '/../Views/Includes/Footer.php';
    }
    public function Historial()
    {
        require_once __DIR__ . '/../Core/Auth.php';
        Auth::checkRole('Administrador');
        include_once __DIR__ . '/../Views/Includes/Header.php';
        include_once __DIR__ . '/../Views/Admin/Historial.php';
        include_once __DIR__ . '/../Views/Includes/Footer.php';
    }
    public function Guia()
    {
        require_once __DIR__ . '/../Core/Auth.php';
        Auth::checkRole(['Cliente', 'Tecnico', 'Supervisor', 'Administrador']);
        include_once __DIR__ . '/../Views/Includes/Header.php';
        include_once __DIR__ . '/../Views/AllUsers/Guia.php';
        include_once __DIR__ . '/../Views/Includes/Footer.php';
    }
}
