<?php

return [
    //Rutas Funcionales y Logicas 
    //
    //Ruta por Defecto Index-Home
    'Default/Index' => [
        'controller' => 'Default',
        'action' => 'index'
    ],
    //
    //Auth del Login 
    //Register el Registrar
    'Auth/Login' => [
        'controller' => 'Auth',
        'action' => 'Login'
    ],
    'Register/Register' => [
        'controller' => 'Register',
        'action' => 'Register'
    ],
    'Register/RegisterAdmin' => [
        'controller' => 'Register',
        'action' => 'RegisterAdmin'
    ],
    'Auth/Logout' => [
        'controller' => 'Auth',
        'action' => 'Logout'
    ],
    //
    //
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
    'Device/CrearDevice' => [
        'controller' => 'Device',
        'action' => 'CrearDispositivo'
    ],
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
    'Device/DeleteDevice' => [
        'controller' => 'Device',
        'action' => 'deleteDevice'
    ],
    'Device/DeleteCategoria' => [
        'controller' => 'Device',
        'action' => 'deleteCategory'
    ],
    //
    //
    //Historial
    'Historial/ListarHistorial' => [
        'controller' => 'Historial',
        'action' => 'listarHistorial'
    ],
    //
    //
    //EstadoTicket
    'EstadoTicket/Crear' => [
        'controller' => 'EstadoTicket',
        'action' => 'crear'
    ],
    'EstadoTicket/ListarEstados' => [
        'controller' => 'EstadoTicket',
        'action' => 'listar'
    ],
    'EstadoTicket/Editar' => [
        'controller' => 'EstadoTicket',
        'action' => 'editar'
    ],
    'EstadoTicket/Actualizar' => [
        'controller' => 'EstadoTicket',
        'action' => 'actualizar'
    ],
    //
    //
    //Ticket
    'Ticket/Agregar' => [
        'controller' => 'Ticket',
        'action' => 'mostrarCrear'
    ],
    'Ticket/Crear' => [
        'controller' => 'Ticket',
        'action' => 'crear'
    ],
    'Ticket/Listar' => [
        'controller' => 'Ticket',
        'action' => 'mostrarLista'
    ],
    'Ticket/Actualizar' => [
        'controller' => 'Ticket',
        'action' => 'update'
    ],
    'Ticket/Editar' => [
        'controller' => 'Ticket',
        'action' => 'edit'
    ],
    'Ticket/Ver' => [
        'controller' => 'Ticket',
        'action' => 'verTicket'
    ],
    'Ticket/Eliminar' => [
        'controller' => 'Ticket',
        'action' => 'eliminar'
    ],
    //
    //Paneles (Lo hice yo, Ale :)
    'Dash/PanelTecnico' => [
        'controller' => 'Paneles',
        'action' => 'PanelTecnico'
    ],
    'Dash/PanelCliente' => [
        'controller' => 'Paneles',
        'action' => 'PanelCliente'
    ],
    'Dash/PanelSupervisor' => [
        'controller' => 'Paneles',
        'action' => 'PanelSupervisor'
    ],
];
