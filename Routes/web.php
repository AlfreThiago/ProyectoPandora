<?php

return [
    //Ruta de Registro
    'Register/Register' => [
        'controller' => 'Register',
        'action' => 'Register'
    ],
    //Ruta de Inicio de sesión
    'Auth/Login' => [
        'controller' => 'Auth',
        'action' => 'Login'
    ],
    'Auth/Logout' => [
        'controller' => 'Auth',
        'action' => 'Logout'
    ],
    //Rutas de Dashboards
    'Dash/home' => [
        'controller' => 'Dash',
        'action' => 'home'
    ],
    'Dash/AdminDash' => [
        'controller' => 'Dash',
        'action' => 'AdminDash'
    ],
    'Dash/ClienteDash' => [
        'controller' => 'Dash',
        'action' => 'ClienteDash'
    ],
    //Rutas de Administración
    'Admin/change-role' => [
        'controller' => 'Admin',
        'action' => 'changeRole'
    ],
];
