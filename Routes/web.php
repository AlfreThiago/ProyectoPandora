<?php

return [
    //Rutas Funcionales y Logicas 
    //
    //Ruta por Defecto Index-Home
    'Default/Index' => [
        'controller' => 'Default',
        'action' => 'index'
    ],
    'Default/Guia' => [
        'controller' => 'Default',
        'action' => 'index2'
    ],
    'Default/Perfil' => [
        'controller' => 'Default',
        'action' => 'perfil'
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
    'Admin/PanelAdmin' => [
        'controller' => 'Admin',
        'action' => 'PanelAdmin'
    ],
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
    //Tecnico
        'Tecnico/PanelTecnico' => [
        'controller' => 'Tecnico',
        'action' => 'PanelTecnico'
    ],
    'Tecnico/MisReparaciones'=> [
        'controller' => 'Tecnico',
        'action' => 'MisReparaciones'
    ],
    'Tecnico/MisRepuestos'=> [
        'controller' => 'Tecnico',
        'action' => 'MisRepuestos'
    ],
    'Tecnico/MisStats'=> [
        'controller' => 'Tecnico',
        'action' => 'MisStats'
    ],
    //
    //
    //Cliente
    'Cliente/PanelCliente' => [
        'controller' => 'Cliente',
        'action' => 'PanelCliente'
    ],
    'Cliente/MisDevice' => [
        'controller' => 'Cliente',
        'action' => 'MisDevice'
    ],
    'Cliente/MisTicket' => [
        'controller' => 'Cliente',
        'action' => 'MisTicket'
    ],    
    //
    //
    //Device
    'Device/ListarDevice' => [
        'controller' => 'Device',
        'action' => 'listarDevice'
    ],
    'Device/ListarCategoria' => [
        'controller' => 'Device',
        'action' => 'listarCategoria'
    ],
    'Device/MostrarCrearDispositivo' => [
        'controller' => 'Device',
        'action' => 'mostrarCrearDispositivo'
    ],
    'Device/CrearDispositivo' => [
        'controller' => 'Device',
        'action' => 'CrearDispositivo'
    ],
    'Device/CrearCategoria' => [
        'controller' => 'Device',
        'action' => 'CrearCategoria'
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
    'EstadoTicket/Eliminar'=> [
        'controller' => 'EstadoTicket',
        'action' => 'eliminar'        
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
    'Ticket/mostrarCrear' => [
        'controller' => 'Ticket',
        'action' => 'mostrarCrear'
    ],
    'Ticket/Listar' => [
        'controller' => 'Ticket',
        'action' => 'mostrarLista'
    ],
    'Ticket/Actualizar' => [
        'controller' => 'Ticket',
        'action' => 'actualizar'
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
    'Dash/PanelSupervisor' => [
        'controller' => 'Paneles',
        'action' => 'PanelSupervisor'
    ],

    'Dash/Ajustes' => [
        'controller' => 'Auth',
        'action' => 'Ajustes'
    ],
    //
    //
    //Inventario
    'Inventario/ListarItem' => [
        'controller' => 'Inventario',
        'action' => 'listarInventario'
    ],
    'Inventario/ListarCategorias' => [
        'controller' => 'Inventario',
        'action' => 'listarCategorias'
    ],
    'Inventario/MostrarCrearItem'=> [
        'controller' => 'Inventario',
        'action' => 'mostrarCrear'
    ], 
    'Inventario/MostrarCrearCategoria'=> [
        'controller' => 'Inventario',
        'action' => 'mostrarCrearCategoria'
    ],
    'Inventario/CrearItem'=> [
        'controller' => 'Inventario',
        'action' => 'crear'
    ],
    'Inventario/CrearCategoria'=> [
        'controller' => 'Inventario',
        'action' => 'crearCategoria'
    ],
    'Inventario/ActualizarItem'=> [],
    'Inventario/EditarItem'=> [],
    'Inventario/EliminarItem'=> [
        'controller' => 'Inventario',
        'action' => 'eliminar'
    ],
    'Inventario/EliminarCategoria'=> [
        'controller' => 'Inventario',
        'action' => 'eliminarCategoria'
    ],
];
