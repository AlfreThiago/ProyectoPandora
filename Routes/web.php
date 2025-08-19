<?php

return [
    'Register/Register' => [
        'controller' => 'Register',
        'action' => 'Register'
    ],
    'Register/RegisterAdmin' => [
        'controller' => 'Register',
        'action' => 'RegisterAdmin'
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
        'action' => 'Login'
    ],
    'Dash/Register' => [
        'controller' => 'Dash',
        'action' => 'Register'
    ],
    'Dash/RegisterAdmin' => [
        'controller' => 'Dash',
        'action' => 'RegisterAdmin'
    ],
    'Dash/Home' => [
        'controller' => 'Dash',
        'action' => 'Home'
    ],
    'Dash/Device' => [
        'controller' => 'Dash',
        'action' => 'CrearDevice'
    ],
    'Dash/CrearCategoriaDevice' => [
        'controller' => 'Dash',
        'action' => 'CrearCategoriaDevice'
    ],
    'Dash/Historial' => [
        'controller' => 'Dash',
        'action' => 'Historial'
    ],
    'Dash/ActualizarDevice' => [
        'controller' => 'Dash',
        'action' => 'ActualizarDevice'
    ],
    'Dash/CrearEstadoTicket' => [
        'controller' => 'Dash',
        'action' => 'CrearEstadoTicket'
    ],
    'Dash/ListaEstadoTicket' => [
        'controller' => 'Dash',
        'action' => 'ListaEstadoTicket'
    ],
    //Rutas de Administración
    'Admin/change-role' => [
        'controller' => 'Admin',
        'action' => 'changeRole'
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
    'Device/CrearCategoria' => [
        'controller' => 'Device',
        'action' => 'CrearCategoria'
    ],
    'Device/Actualizar-Device' => [
        'controller' => 'Device',
        'action' => 'ActualizarDevice'
    ],
    'Device/Delete-Device' => [
        'controller' => 'Device',
        'action' => 'DeleteDevice'
    ],
    'Device/Actualizar-Category' => [
        'controller' => 'Device',
        'action' => 'ActualizarCategory'
    ],
    'Device/Delete-Category' => [
        'controller' => 'Device',
        'action' => 'deleteCategory'
    ],
    // Rutas de Estados de Ticket
    'EstadoTicket/crear' => [
        'controller' => 'EstadoTicket',
        'action' => 'crear'
    ],
    'EstadoTicket/Listar' => [
        'controller' => 'EstadoTicket',
        'action' => 'listar'
    ],
    'EstadoTicket/Edit' => [
        'controller' => 'EstadoTicket',
        'action' => 'editar'
    ],

    'EstadoTicket/Actualizar' => [
        'controller' => 'EstadoTicket',
        'action' => 'actualizar'
    ],
    // Rutas de Guia
    'Dash/Guia' => [
        'controller' => 'Dash',
        'action' => 'Guia'
    ],
    //Rutas Funcionales y Logicas 
    //Admin
    'Admin/ListarUsers' => [
        'controller' => 'Admin',
        'action' => 'listarUsers'
    ],
    'Admin/ListarClientes' => [
        'controller' => 'Admin',
        'action' => 'listarCli'
    ],
    'Admin/ListarTecnicos' => [
        'controller' => 'Admin',
        'action' => 'listarTecs'
    ],
    'Admin/ListarSupervisores' => [
        'controller' => 'Admin',
        'action' => 'listarSupers'
    ],
    'Admin/ListarAdmins' => [
        'controller' => 'Admin',
        'action' => 'listarAdmins'
    ],
    'Admin/ActualizarUser' => [
        'controller' => 'Admin',
        'action' => 'ActualizarUser'
    ],
    //Device
    'Device/ListarDevice' => [
        'controller' => 'Device',
        'action' => 'listarDevice'
    ],
    'Device/ListarCategoria' => [
        'controller' => 'Device',
        'action' => 'listarCategoria'
    ],
    'Device/ActualizarDevice' => [
        'controller' => 'Device',
        'action' => 'ActualizarDevice'
    ],
];
