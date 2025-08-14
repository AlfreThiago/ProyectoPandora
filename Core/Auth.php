<?php
require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/Database.php';

// Auth es una clase que maneja la autenticación y autorización de usuarios en la aplicación.
// Proporciona métodos para verificar si un usuario está logueado, obtener el usuario actual,
// y verificar si el usuario tiene un rol específico.
class Auth
{
    // Se verifica si el usuario está logueado
    public static function check()
    {
        session_start();
        return isset($_SESSION['user']);
    }

    // Obtiene el usuario actual de la sesión
    public static function user()
    {
        session_start();
        return $_SESSION['user'] ?? null;
    }

    // Verifica si el usuario tiene el rol requerido
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
}
