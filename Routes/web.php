<?php

return [
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
    'Admin/DeleteUser' => [
        'controller' => 'Admin',
        'action' => 'DeleteUser'
    ],
    //
    //
    //Device
    'Device/CrearCategoria' => [
        'controller' => 'Device',
        'action' => 'CrearCategoria'
    ],
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
    'Device/ActualizarCategoria' => [
        'controller' => 'Device',
        'action' => 'ActualizarCategoria'
    ],
    //
    //
    //Historial
    'Historial/ListarHistorial' => [
        'controller' => 'Historial',
        'action' => 'listarHistorial'
    ],

];
