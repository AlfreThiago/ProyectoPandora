<?php
/**
 * CSRF token helper minimalista.
 * Uso:
 *   - En inicio de request: Csrf::init();
 *   - En formularios: echo Csrf::input();
 *   - En controladores POST: Csrf::validateOrThrow();
 */
class Csrf
{
    private const SESSION_KEY = '_csrf_tokens';
    private const TOKEN_NAME = '_csrf';
    private const MAX_TOKENS = 25; // limitar cantidad para no crecer indefinidamente
    private const TTL_SECONDS = 1800; // 30 minutos

    public static function init(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        if (!isset($_SESSION[self::SESSION_KEY]) || !is_array($_SESSION[self::SESSION_KEY])) {
            $_SESSION[self::SESSION_KEY] = [];
        }
    }

    public static function generate(): string
    {
        self::init();
        $token = bin2hex(random_bytes(32));
        $_SESSION[self::SESSION_KEY][$token] = time();
        // Recortar tokens viejos
        if (count($_SESSION[self::SESSION_KEY]) > self::MAX_TOKENS) {
            // borrar los más antiguos
            asort($_SESSION[self::SESSION_KEY]);
            $remove = count($_SESSION[self::SESSION_KEY]) - self::MAX_TOKENS;
            foreach (array_keys($_SESSION[self::SESSION_KEY]) as $tk) {
                if ($remove-- <= 0) break;
                unset($_SESSION[self::SESSION_KEY][$tk]);
            }
        }
        return $token;
    }

    public static function input(): string
    {
        $token = self::generate();
        return '<input type="hidden" name="' . self::TOKEN_NAME . '" value="' . htmlspecialchars($token, ENT_QUOTES, 'UTF-8') . '">';
    }

    public static function validate(?string $provided): bool
    {
        self::init();
        if (!$provided || !isset($_SESSION[self::SESSION_KEY][$provided])) {
            return false;
        }
        $ts = (int)$_SESSION[self::SESSION_KEY][$provided];
        unset($_SESSION[self::SESSION_KEY][$provided]); // un solo uso
        if ((time() - $ts) > self::TTL_SECONDS) {
            return false;
        }
        return true;
    }

    public static function validateOrThrow(): void
    {
        $ok = self::validate($_POST[self::TOKEN_NAME] ?? null);
        if (!$ok) {
            http_response_code(403);
            echo 'CSRF token inválido o expirado.';
            exit;
        }
    }
}
?>