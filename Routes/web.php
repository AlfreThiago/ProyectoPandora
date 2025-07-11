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
    'Dash/Home' => [
        'controller' => 'Dash',
        'action' => 'Home'
    ],
    'Dash/AdminDash' => [
        'controller' => 'Dash',
        'action' => 'AdminDash'
    ],
    'Dash/SupervisorDash' => [
        'controller' => 'Dash',
        'action' => 'SupervisorDash'
    ],
    'Dash/TecnicoDash' => [
        'controller' => 'Dash',
        'action' => 'TecnicoDash'
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
    'Admin/Edit-user' => [
        'controller' => 'Admin',
        'action' => 'EditUser'
    ],
    'Admin/Delete-user' => [
        'controller' => 'Admin',
        'action' => 'DeleteUser'
    ],
];
