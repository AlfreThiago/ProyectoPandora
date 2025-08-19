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
    'Dash/ListaUsers' => [
        'controller' => 'Dash',
        'action' => 'ListaUser'
    ],
    'Dash/ListaCliente' => [
        'controller' => 'Dash',
        'action' => 'ListaCliente'
    ],
    'Dash/ListaTecnico' => [
        'controller' => 'Dash',
        'action' => 'ListaTecnico'
    ],
    'Dash/ListaSupervisor' => [
        'controller' => 'Dash',
        'action' => 'ListaSupervisor'
    ],
    'Dash/ListaAdmin' => [
        'controller' => 'Dash',
        'action' => 'ListaAdmin'
    ],
    'Dash/Device' => [
        'controller' => 'Dash',
        'action' => 'CrearDevice'
    ],
    'Dash/ListaDispositivos' => [
        'controller' => 'Dash',
        'action' => 'ListaDispositivos'
    ],
    'Dash/ListaCategoriaDevice' => [
        'controller' => 'Dash',
        'action' => 'ListaCategoriaDevice'
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
    'Admin/ActualizarUser' => [
        'controller' => 'Admin',
        'action' => 'ActualizarUser'
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
    ]
];
