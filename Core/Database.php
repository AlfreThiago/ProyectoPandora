<?php

class Database
{
    private ?\mysqli $connection = null;

    private function env(string $key, $default = null)
    {
        // Leer primero de variables de entorno del sistema
        $val = getenv($key);
        if ($val === false && isset($_ENV[$key])) $val = $_ENV[$key];
        if ($val === false && isset($_SERVER[$key])) $val = $_SERVER[$key];
        if ($val !== false && $val !== null && $val !== '') return $val;

        // Intento simple de leer .env (sin dependencias)
        $envPath = dirname(__DIR__) . '/.env';
        if (is_file($envPath) && is_readable($envPath)) {
            $lines = @file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [];
            foreach ($lines as $line) {
                $line = ltrim($line);
                if ($line === '' || $line[0] === '#') continue;
                if (strpos($line, '=') === false) continue;
                [$k, $v] = explode('=', $line, 2);
                if (trim($k) === $key) {
                    $v = trim($v, " \t\"'\r\n");
                    return $v !== '' ? $v : $default;
                }
            }
        }
        return $default;
    }

    public function connectDatabase(): void
    {
        // Permitir configuración vía .env, con defaults de respaldo
        $host = (string)$this->env('DB_HOST', '127.0.0.1');
        $user = (string)$this->env('DB_USER', 'root');
        $password = (string)$this->env('DB_PASS', '');
        $database = (string)$this->env('DB_NAME', 'pandoraDB');
        $port = (int)$this->env('DB_PORT', 3306);
        $timeout = (int)$this->env('DB_TIMEOUT', 5); // segundos

        $mysqli = \mysqli_init();
        if (!$mysqli) {
            throw new \RuntimeException('No se pudo inicializar la extensión mysqli');
        }
        // Timeout de conexión para evitar cuelgues largos
        if (defined('MYSQLI_OPT_CONNECT_TIMEOUT')) {
            @\mysqli_options($mysqli, MYSQLI_OPT_CONNECT_TIMEOUT, $timeout);
        }
        // Intentar conectar
        $ok = @$mysqli->real_connect($host, $user, $password, $database, $port);
        if (!$ok) {
            // Mensaje acotado para producción; el detalle queda en error_log
            error_log('DB connect error: ' . ($mysqli->connect_error ?? 'unknown'));
            throw new \RuntimeException('No se pudo conectar a la base de datos');
        }
        @$mysqli->set_charset('utf8mb4');
        $this->connection = $mysqli;
    }

    public function getConnection(): ?\mysqli
    {
        return $this->connection;
    }
}
