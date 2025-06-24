<?php

// Cargar archivo de rutas
$routes = require_once __DIR__ . '../../routes/web.php';

// Obtener ruta actual desde la URL
$route = $_GET['route'] ?? 'user/register'; // Ruta por defecto

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
                $controller->$action();
            } else {
                echo "❌ Acción '$action' no encontrada.";
            }
        } else {
            echo "❌ Clase '$className' no existe.";
        }
    } else {
        echo "❌ Controlador '$controllerFile' no encontrado.";
    }
} else {
    echo "❌ Ruta '$route' no registrada.";
}
