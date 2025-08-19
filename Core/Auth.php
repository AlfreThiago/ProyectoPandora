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
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['user']) ? $_SESSION['user'] : null;
    }
    public static function checkRole($requiredRoles)
    {
        session_start();
        if (!isset($_SESSION['user'])) {
            header('Location: /ProyectoPandora/Public/index.php?route=Auth/Login');
            exit;
        }
        $user = $_SESSION['user'];
        // Permitir array de roles
        if (is_array($requiredRoles)) {
            if (!in_array($user['role'], $requiredRoles)) {
                echo "Acceso denegado: se requiere uno de los roles " . implode(', ', $requiredRoles) . ".";
                exit;
            }
        } else {
            if ($user['role'] !== $requiredRoles) {
                echo "Acceso denegado: se requiere el rol $requiredRoles.";
                exit;
            }
        }
    }

    public static function login($user)
    {
        session_start();
        $_SESSION['user'] = $user;
    }

    public static function logout()
    {
        session_start();
        session_unset();
        session_destroy();
    }
}
