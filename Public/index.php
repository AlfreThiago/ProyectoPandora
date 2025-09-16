<?php
session_start();

$currentUrl = $_SERVER['REQUEST_URI'];

// No guardar si es acción de "VerTicket" (para evitar bucle al volver)
if (!isset($_GET['route']) || strpos($_GET['route'], 'Ticket/Ver') === false) {
    $_SESSION['prev_url'] = $currentUrl;
}

$routes = require_once __DIR__ . '../../routes/web.php';
$route = $_GET['route'] ?? 'Default/Index';
if (isset($routes[$route])) {
    $controllerName = $routes[$route]['controller'];
    $action = $routes[$route]['action'];

    $controllerFile = __DIR__ . "../../Controllers/{$controllerName}Controller.php";

    if (file_exists($controllerFile)) {
        require_once $controllerFile;

        $className = $controllerName . 'Controller';

        if (class_exists($className)) {
            $controller = new $className();

            if (method_exists($controller, $action)) {
                // Si la acción espera un parámetro 'id' en la URL
                if (isset($_GET['id'])) {
                    $controller->$action($_GET['id']);
                } else {
                    $controller->$action();
                }
            } else {
                echo " Acción '$action' no encontrada.";
            }
        } else {
            echo " Clase '$className' no existe.";
        }
    } else {
        echo " Controlador '$controllerFile' no encontrado.";
    }
} else {
    echo " Ruta '$route' no registrada.";
}
