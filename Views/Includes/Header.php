<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/ProyectoPandora/Public/css/AdminDash.css"> <!-- AdminDash.css -->
    <link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>
    <title>Home Portal</title>
</head>

<body>
    <div class="menu-btn sidebar-btn" id="sidebar-btn">
        <i class='bx bx-menu-wider'></i>
        <i class='bx bx-x'></i>
    </div>
    <div class="sidebar" id="sidebar">
        <div class="header">
            <div class="menu-btn" id="menu-btn">
                <i class='bx bx-arrow-left'></i>
            </div>
            <div class="brand">
                <img class="brand-light" src="img/Innovasys_V2.png" alt="logo">
                <img class="brand-dark" src="img/Innovasys_V2.png" alt="logo">
                <span></span>
            </div>
        </div>
        <div class="menu-conteiner">
            <ul class="menu">
                <li class="menu-item menu-item-static active">
                    <a href="/ProyectoPandora/Public/index.php?route=Dash/Home" class="menu-link">
                        <i class='bx bx-home'></i>
                        <span>Home</span>
                    </a>
                </li>
                <!-----------------------------------------------⇑-------------------------------Parte obligatoria para todos los Dash-->


                <?php if (isset($_SESSION['user'])): ?>
                    <?php $role = strtolower($_SESSION['user']['role']); ?>

                    <?php if ($role === 'administrador'): ?>
                        <li class="menu-item menu-item-dropdown">
                            <a href="#" class="menu-link">
                                <i class='bx bx-user'></i>
                                <span>Usuarios</span>
                                <i class='bx bx-arrow-down-stroke'></i>
                            </a>
                            <ul class="sub-menu">
                                <li><a href="index.php?route=Dash/Admin" class="sub-menu-link">Todos los users</a></li>
                                <li><a href="/ProyectoPandora/Public/index.php?route=Dash/TablaCliente" class="sub-menu-link">Clientes</a></li>
                                <li><a href="/ProyectoPandora/Public/index.php?route=Dash/TablaTecnico" class="sub-menu-link">Técnicos</a></li>
                                <li><a href="/ProyectoPandora/Public/index.php?route=Dash/TablaSupervisor" class="sub-menu-link">Supervisor</a></li>
                                <li><a href="/ProyectoPandora/Public/index.php?route=Dash/TablaAdmin" class="sub-menu-link">Admins</a></li>
                            </ul>
                        </li>
                        <li class="menu-item menu-item-dropdown">
                            <a href="#" class="menu-link">
                                <i class='bx bx-plus-square'></i>
                                <span>Dispositivos</span>
                                <i class='bx bx-arrow-down-stroke'></i>
                            </a>
                            <ul class="sub-menu">
                                <li><a href="/ProyectoPandora/Public/index.php?route=Dash/TablaDispositivos" class="sub-menu-link">Lista</a></li>
                            </ul>
                        </li>
                        <li class="menu-item menu-item-dropdown">
                            <a href="#" class="menu-link">
                                <i class='bx bx-plus-square'></i>
                                <span>Añadir</span>
                                <i class='bx bx-arrow-down-stroke'></i>
                            </a>
                            <ul class="sub-menu">
                                <li><a href="/ProyectoPandora/Public/index.php?route=Register/RegisterAdminPortal" class="sub-menu-link">Usuarios</a></li>
                                <li><a href="/ProyectoPandora/Public/index.php?route=Dash/Device" class="sub-menu-link">Dispositivos</a></li>
                                <li><a href="/ProyectoPandora/Public/index.php?route=Device/AgregarCategoria" class="sub-menu-link">Categorias</a></li>
                            </ul>
                        </li>

                    <?php elseif ($role === 'supervisor'): ?>
                        <!-- Supervisor: ve técnicos y clientes -->
                        <li class="menu-item menu-item-dropdown">
                            <a href="#" class="menu-link">
                                <i class='bx bx-user'></i>
                                <span>Usuarios</span>
                                <i class='bx bx-arrow-down-stroke'></i>
                            </a>
                            <ul class="sub-menu">
                                <li><a href="/ProyectoPandora/Public/index.php?route=Dash/TablaCliente" class="sub-menu-link">Clientes</a></li>
                                <li><a href="/ProyectoPandora/Public/index.php?route=Dash/TablaTecnico" class="sub-menu-link">Técnicos</a></li>
                            </ul>
                        </li>

                    <?php elseif ($role === 'tecnico'): ?>
                        <!-- Técnico: solo ve Reparaciones y tickets -->
                        <li class="menu-item menu-item-dropdown">
                            <a href="index.php?route=Dash/Tecnico" class="menu-link">
                                <i class='bxr  bx-spanner'></i>
                                <span>Reparaciones</span>
                            </a>
                        </li>
                        <li class="menu-item menu-item-dropdown">
                            <a href="#" class="menu-link">
                                <i class='bxr  bx-ticket'></i>
                                <span>Tickets</span>
                            </a>
                        </li>

                    <?php elseif ($role === 'cliente'): ?>
                        <li class="menu-item menu-item-dropdown">
                            <a href="index.php?route=Dash/Device" class="menu-link">
                                <i class='bx bx-user'></i>
                                <span>Agregar Dispositivo</span>
                            </a>
                        </li>
                    <?php endif; ?>

                <?php else: ?>
                    <!-- No logueado -->
                    <li class="menu-item menu-item-static">
                        <a href="/ProyectoPandora/Public/index.php?route=Auth/Login" class="menu-link">
                            <i class='bx bx-arrow-out-right-square-half'></i>
                            <span>Iniciar sesión</span>
                        </a>
                    </li>
                    <li class="menu-item menu-item-static">
                        <a href="/ProyectoPandora/Public/index.php?route=Register/Register" class="menu-link">
                            <i class='bxr  bx-form'></i>
                            <span>Registrarse</span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
        <script src="/ProyectoPandora/Public/js/Sidebar.js"></script>
    </div>