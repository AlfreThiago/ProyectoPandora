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
