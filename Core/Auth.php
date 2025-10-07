<?php
require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/Database.php';

class Auth
{
    /**
     * Garantiza que la sesión esté iniciada antes de acceder a $_SESSION.
     */
    private static function ensureSession(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    public static function check(): bool
    {
        self::ensureSession();
        return isset($_SESSION['user']);
    }

    public static function user(): ?array
    {
        self::ensureSession();
        return $_SESSION['user'] ?? null;
    }
    public static function checkRole($requiredRoles): void
    {
        self::ensureSession();
        if (!isset($_SESSION['user'])) {
            header('Location: /ProyectoPandora/Public/index.php?route=Auth/Login');
            exit;
        }
        $user = $_SESSION['user'];
        
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

    public static function login($user): void
    {
        self::ensureSession();
        // Mitiga fijación de sesión
        if (function_exists('session_regenerate_id')) {
            @session_regenerate_id(true);
        }
        $_SESSION['user'] = $user;
    }

    public static function logout(): void
    {
        self::ensureSession();
        $_SESSION = [];
        session_unset();
        // Elimina la cookie de sesión si aplica
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'] ?? false, $params['httponly'] ?? false);
        }
        session_destroy();
        // Opcional: regenerar ID post-logout
        if (function_exists('session_regenerate_id')) {
            @session_regenerate_id(true);
        }
    }
}