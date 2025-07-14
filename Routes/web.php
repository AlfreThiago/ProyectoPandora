<?php

return [
    //Ruta de Registro
    'Register/Register' => [
        'controller' => 'Register',
        'action' => 'Register'
    ],
    'Register/RegisterAdminPortal' => [
        'controller' => 'Register',
        'action' => 'RegisterAdminPortal'
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
        'action' => 'HomeDash'
    ],
    'Dash/Admin' => [
        'controller' => 'Dash',
        'action' => 'AdminDash'
    ],
    'Dash/Supervisor' => [
        'controller' => 'Dash',
        'action' => 'SupervisorDash'
    ],
    'Dash/Tecnico' => [
        'controller' => 'Dash',
        'action' => 'TecnicoDash'
    ],
    'Dash/Cliente' => [
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
