<?php

return [

    'Register/Register' => [
        'controller' => 'Register',
        'action' => 'Register'
    ],
    'Register/RegisterAdminPortal' => [
        'controller' => 'Register',
        'action' => 'RegisterAdminPortal'
    ],

    'Auth/Login' => [
        'controller' => 'Auth',
        'action' => 'Login'
    ],
    'Auth/Logout' => [
        'controller' => 'Auth',
        'action' => 'Logout'
    ],
    //Rutas de Dashboards
    'Dash/Login' => [
        'controller' => 'Dash',
        'action' => 'LoginDash'
    ],
    'Dash/Register' => [
        'controller' => 'Dash',
        'action' => 'RegisterDash'
    ],
    'Dash/RegisterAdminPortal' => [
        'controller' => 'Dash',
        'action' => 'RegisterAdminPortal'
    ],
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
    'Dash/TablaCliente' => [
        'controller' => 'Dash',
        'action' => 'TablaCliente'
    ],
    'Dash/TablaTecnico' => [
        'controller' => 'Dash',
        'action' => 'TablaTecnico'
    ],
    'Dash/TablaSupervisor' => [
        'controller' => 'Dash',
        'action' => 'TablaSupervisor'
    ],
    'Dash/TablaAdmin' => [
        'controller' => 'Dash',
        'action' => 'TablaAdmin'
    ],
    'Dash/Device' => [
        'controller' => 'Dash',
        'action' => 'DeviceDash'
    ],
    'Dash/TablaDispositivos' => [
        'controller' => 'Dash',
        'action' => 'TablaDispositivos'
    ],
    'Dash/Category' => [
        'controller' => 'Dash',
        'action' => 'CategoryDash'
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
    // Rutas de Dispositivos
    'Device/Agregar' => [
        'controller' => 'Device',
        'action' => 'AgregarDispositivo'
    ],
    'Device/AgregarCategoria' => [
        'controller' => 'Device',
        'action' => 'AgregarCategoria'
    ],
    'Device/Edit-device' => [
        'controller' => 'Device',
        'action' => 'EditDevice'
    ],
    'Device/Delete-device' => [
        'controller' => 'Device',
        'action' => 'DeleteDevice'
    ],
];
