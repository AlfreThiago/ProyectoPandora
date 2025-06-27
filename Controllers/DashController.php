<?php
class DashController
{
    public function AdminDash()
    {
        require_once __DIR__ . '/../Core/Auth.php';
        Auth::checkRole('Administrador');
        include_once __DIR__ . '/../Views/Shared/AdminHeader.php';
        include_once __DIR__ . '/../Views/Dashboard/AdminDash.php';
    }
    public function ClienteDash()
    {
        require_once __DIR__ . '/../Core/Auth.php';
        Auth::checkRole('Cliente');
        include_once __DIR__ . '/../Views/Shared/ClienteHeader.php';
        include_once __DIR__ . '/../Views/Dashboard/ClienteDash.php';
    }
}
