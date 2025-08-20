<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/ProyectoPandora/Public/css/AdminDash.css">
    <link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>
    <link href='https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Home Portal</title>
</head>

<body>
    <nav class="sidebar">
        <div class="header">
            <!-- Zona de la Imagen/logo  -->
            <div class="nav_image flex">
                <div class="brand">
                    <img class="brand-light" src="img/Innovasys_V2.png" alt="logo">
                    <img class="brand-dark" src="img/Innovasys_V2.png" alt="logo">
                </div>
            </div>
        </div>
        <div class="menu-conteiner">
            <ul class="menu-items">
                <div class="menu_title flex">
                    <span class="title">Menu</span>
                    <span class="line"></span>
                </div>
                <li class="item menu-item menu-item-static">
                    <a href="/ProyectoPandora/Public/index.php?route=Dash/Home" class="link flex">
                        <i class='bx bx-home'></i>
                        <span>Home</span>
                    </a>
                </li>
                <!-----------------------------------------------⇑-------------------------------Parte obligatoria para todos los Dash-->
                <?php if (isset($_SESSION['user'])): ?>
                    <?php $role = strtolower($_SESSION['user']['role']); ?>

                    <?php if ($role === 'administrador'): ?>
                        <!-- Admin: ve todos los usuarios y opción de añadir -->
                        <!-- Historial -->
                        <li class="item">
                            <a href="/ProyectoPandora/Public/index.php?route=Historial/ListarHistorial" class="link flex">
                                <i class='bxr  bx-history'></i>
                                <span>Historial</span>
                            </a>
                        </li>
                        <!-- Dispositivos -->
                        <li class="item menu-item-dropdown">
                            <a href="#" class="link flex">
                                <i class='bx bx-devices'></i>
                                <span>Dispositivos</span>
                                <i class='bx bx-arrow-down-stroke oculto'></i>
                            </a>
                            <ul class="sub-menu">
                                <li><a href="/ProyectoPandora/Public/index.php?route=Device/ListarDevice" class="sub-menu-link">Lista de Dispositivos</a></li>
                                <li><a href="/ProyectoPandora/Public/index.php?route=Device/ListarCategoria" class="sub-menu-link">Lista de Categorías</a></li>
                            </ul>
                        </li>
                        <!-- Usuarios // CORREJIDO 👍-->
                        <li class="item menu-item-dropdown">
                            <a href="#" class="link flex">
                                <i class='bx bx-user'></i>
                                <span>Usuarios</span>
                                <i class='bx bx-arrow-down-stroke oculto'></i>
                            </a>
                            <!-- Zona del submenu de usuarios -->
                            <ul class="sub-menu">
                                <li><a href="/ProyectoPandora/Public/index.php?route=Admin/ListarUsers" class="sub-menu-link">Todos los users</a></li>
                                <li><a href="/ProyectoPandora/Public/index.php?route=Admin/ListarClientes" class="sub-menu-link">Clientes</a></li>
                                <li><a href="/ProyectoPandora/Public/index.php?route=Admin/ListarTecnicos" class="sub-menu-link">Técnicos</a></li>
                                <li><a href="/ProyectoPandora/Public/index.php?route=Admin/ListarSupervisores" class="sub-menu-link">Supervisor</a></li>
                                <li><a href="/ProyectoPandora/Public/index.php?route=Admin/ListarAdmins" class="sub-menu-link">Admins</a></li>
                            </ul>
                        </li>
                        <!-- Ticket -->
                        <li class="item menu-item menu-item-dropdown">
                            <a href="#" class="link flex">
                                <i class='bx bx-ticket'></i>
                                <span>Tickets</span>
                                <i class="bx bx-arrow-down-stroke oculto"></i>
                            </a>
                            <ul class="sub-menu">
                                <li class="sub-menu">
                                <li><a href="/ProyectoPandora/Public/index.php?route=Dash/Ticket" class="sub-menu-link">Tickets</a></li>
                                <li><a href="/ProyectoPandora/Public/index.php?route=Dash/ListaTicket" class="sub-menu-link">Lista de Tickets</a></li>
                                <li><a href="/ProyectoPandora/Public/index.php?route=EstadoTicket/Listar" class="sub-menu-link">Lista de Estados</a></li>
                            </ul>
                        </li>

                        <li class="item menu-item-dropdown">
                            <a href="#" class="link flex">
                                <i class='bx bx-plus-square'></i>
                                <span>Añadir</span>
                                <i class='bx bx-arrow-down-stroke oculto'></i>
                            </a>
                            <!-- Zona submenu para Añadir -->
                            <ul class="sub-menu">
                                <li><a href="/ProyectoPandora/Public/index.php?route=Register/RegisterAdmin" class="sub-menu-link">Usuarios</a></li>
                                <li><a href="/ProyectoPandora/Public/index.php?route=Dash/Device" class="sub-menu-link">Dispositivo</a></li>
                            </ul>
                        </li>
                    <?php elseif ($role === 'supervisor'): ?>
                        <!-- Supervisor: ve técnicos y clientes -->
                        <li class="item menu-item-dropdown">
                            <a href="#" class="link flex">
                                <i class='bx bx-user'></i>
                                <span>Usuarios</span>
                                <i class='bx bx-arrow-down-stroke'></i>
                            </a>
                            <!-- Submenu de usuarios -->
                            <ul class="sub-menu">
                                <li><a href="/ProyectoPandora/Public/index.php?route=Dash/ListaCliente" class="sub-menu-link">Clientes</a></li>
                                <li><a href="/ProyectoPandora/Public/index.php?route=Dash/ListaTecnico" class="sub-menu-link">Técnicos</a></li>
                            </ul>
                        </li>
                        <li class="item menu-item menu-item-static">
                            <a href="/ProyectoPandora/Public/index.php?route=Dash/Guia" class="link flex">
                                <i class="bx bx-guia">
                                    <span>Guia</span>
                                </i>
                            </a>
                        </li>
                    <?php elseif ($role === 'tecnico'): ?>
                        <!-- Técnico: solo ve Reparaciones y tickets -->
                        <!-- Reparaciones -->
                        <li class="item menu-item-static">
                            <a href="index.php?route=Dash/Tecnico" class="link flex">
                                <i class='bxr  bx-spanner'></i>
                                <span>Reparaciones</span>
                            </a>
                        </li>
                        <!-- Tickets -->
                        <li class="item menu-item-static">
                            <a href="#" class="link flex">
                                <i class='bxr  bx-ticket'></i>
                                <span>Tickets</span>
                            </a>
                        </li>
                        <li class="item menu-item menu-item-static">
                            <a href="/ProyectoPandora/Public/index.php?route=Dash/Guia" class="link flex">
                                <i class="bx bx-guia">
                                    <span>Guia</span>
                                </i>
                            </a>
                        </li>
                    <?php elseif ($role === 'cliente'): ?>
                        <!-- Agregar Dispositivo -->
                        <li class="item menu-item-static">
                            <a href="index.php?route=Dash/Device" class="link flex">
                                <i class='bx bx-user'></i>
                                <span>Agregar Dispositivo</span>
                            </a>
                        </li>
                        <li class="item menu-item menu-item-static">
                            <a href="/ProyectoPandora/Public/index.php?route=Dash/Guia" class="link flex">
                                <i class="bx bx-guia">
                                    <span>Guia</span>
                                </i>
                            </a>
                        </li>
                    <?php endif; ?>
                <?php else: ?>
                    <!-- No logueado -->
                    <!-- Iniciar sesion y Registro -->
                    <li class="item ">
                        <a href="/ProyectoPandora/Public/index.php?route=Auth/Login" class="link flex">
                            <i class='bx bx-arrow-out-right-square-half'></i>
                            <span>Iniciar sesión</span>
                        </a>
                    </li>
                    <li class="item ">
                        <a href="/ProyectoPandora/Public/index.php?route=Register/Register" class="link flex">
                            <i class='bxr  bx-form'></i>
                            <span>Registrarse</span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
    <section class="Contenedor-formulario-principal">
    </section>
</body>

</html>