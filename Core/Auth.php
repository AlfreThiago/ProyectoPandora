<?php
require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/Database.php';

class Auth
{
    
    public static function check()
    {
        session_start();
        return isset($_SESSION['user']);
    }

    public static function user()
    {
        session_start();
        return $_SESSION['user'] ?? null;
    }

   
    public static function checkRole($requiredRole)
    {
        session_start();
        if (!isset($_SESSION['user'])) {
            header('Location: /ProyectoPandora/Public/index.php?route=Auth/Login');
            exit;
        }

        $user = $_SESSION['user'];
        if ($user['role'] !== $requiredRole) {
            echo "Acceso denegado: se requiere el rol $requiredRole.";
            exit;
        }
    }
}
