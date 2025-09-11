<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/ProyectoPandora/Public/css/AdminDash.css">
    <link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>
    <link href='https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Home Portal</title>
</head>

<body>
    <Aside class="sidebar">
        <nav class="sidebar">
            <div>
                <div class="nav_image flex">
                    <div class="brand">
                        <img class="brand-dark" src="/ProyectoPandora/Public/img/Innovasys_V2.png" alt="logo">
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
                        <a href="/ProyectoPandora/Public/index.php?route=Default/Index" class="link flex">
                            <i class='bx bx-home'></i>
                            <span>Home</span>
                        </a>
                    </li>
                    <?php if (isset($_SESSION['user'])): ?>
                        <?php $role = strtolower($_SESSION['user']['role']); ?>

                        <?php if ($role === 'administrador'): ?>
                            <!-- Admin: ve todos los usuarios y opción de añadir -->
                            <li class="item menu-item menu-item-static">
                                <a href="/ProyectoPandora/Public/index.php?route=Admin/PanelAdmin" class="link flex">
                                    <i class='bx  bx-iframe'></i>
                                    <span>Panel Admin</span>
                                </a>
                            </li>
                            <!-- Historial -->
                            <li class="item">
                                <a href="/ProyectoPandora/Public/index.php?route=Historial/ListarHistorial" class="link flex">
                                    <i class='bxr  bx-history'></i>
                                    <span>Historial</span>
                                </a>
                            </li>
                            <!-- Ticket //NO CORREJIDO 🥺 -->
                            <!-- <li class="item menu-item menu-item-dropdown">
                                <a href="#" class="link flex">
                                    <i class='bx bx-ticket'></i>
                                    <span>Tickets</span>
                                    <i class="bx bx-arrow-down-stroke oculto"></i>
                                </a>
                                <ul class="sub-menu">
                                    <li class="sub-menu">

                                    <li><a href="/ProyectoPandora/Public/index.php?route=Ticket/Listar" class="sub-menu-link">Lista de Tickets</a></li>
                                    <li><a href="/ProyectoPandora/Public/index.php?route=EstadoTicket/ListarEstados" class="sub-menu-link">Lista de Estados</a></li>
                                </ul>
                            </li> -->
                        <?php elseif ($role === 'supervisor'): ?>
                            <li class="item menu-item-static">
                                <a href="index.php?route=Dash/PanelSupervisor" class="link flex">
                                    <i class='bxr  bx-ticket'></i>
                                    <span>Panel Supervisor</span>
                                </a>
                            </li>
                            <!-- Supervisor: ve técnicos y clientes -->
                            <!-- <li class="item menu-item-dropdown">
                                <a href="#" class="link flex">
                                    <i class='bx bx-user'></i>
                                    <span>Usuarios</span>
                                    <i class='bx bx-arrow-down-stroke'></i>
                                </a>
                                Submenu de usuarios 
                                <ul class="sub-menu">
                                    <li><a href="/ProyectoPandora/Public/index.php?route=Dash/ListaCliente" class="sub-menu-link">Clientes</a></li>
                                    <li><a href="/ProyectoPandora/Public/index.php?route=Dash/ListaTecnico" class="sub-menu-link">Técnicos</a></li>
                                </ul>
                            </li> -->
                            <li class="item menu-item menu-item-static">
                                <a href="/ProyectoPandora/Public/index.php?route=Dash/Guia" class="link flex">
                                    <i class='bx  bx-help-circle'></i>
                                    <span>Guia</span>
                                    </i>
                                </a>
                            </li>
                        <?php elseif ($role === 'tecnico'): ?>
                            <!-- Técnico: solo ve Reparaciones y tickets -->
                            <li class="item menu-item-static">
                                <a href="index.php?route=Dash/PanelTecnico" class="link flex">
                                    <i class='bxr  bx-ticket'></i>
                                    <span>Panel Tecnico</span>
                                </a>
                            </li>
                            <li class="item menu-item menu-item-static">
                                <a href="/ProyectoPandora/Public/index.php?route=Dash/Guia" class="link flex">
                                    <i class='bx  bx-help-circle'></i>
                                    <span>Guia</span>
                                    </i>
                                </a>
                            </li>
                        <?php elseif ($role === 'cliente'): ?>
                            <li class="item menu-item-static">
                                <a href="index.php?route=Cliente/PanelCliente" class="link flex">
                                    <i class='bx  bx-devices'></i>
                                    <span>Panel Cliente</span>
                                </a>
                            </li>
                            <li class="item menu-item menu-item-static">
                                <a href="/ProyectoPandora/Public/index.php?route=Dash/Guia" class="link flex">
                                    <i class='bx  bx-help-circle'></i>
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
    </aside>

</body>

</html>