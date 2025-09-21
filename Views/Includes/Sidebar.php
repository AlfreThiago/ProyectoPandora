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
                            <!-- Admin: Usuarios y 'Otros' (Estados y Categorías) -->
                            <li class="item menu-item menu-item-static">
                                <a href="/ProyectoPandora/Public/index.php?route=Admin/ListarUsers" class="link flex">
                                    <i class='bx bx-user-circle'></i>
                                    <span>Usuarios</span>
                                </a>
                            </li>
                            <li class="item menu-item menu-item-static">
                                <a href="/ProyectoPandora/Public/index.php?route=EstadoTicket/ListarEstados" class="link flex">
                                    <i class='bx bx-list-check'></i>
                                    <span>Estados</span>
                                </a>
                            </li>
                            <li class="item menu-item menu-item-static">
                                <a href="/ProyectoPandora/Public/index.php?route=Device/ListarCategoria" class="link flex">
                                    <i class='bx bx-category'></i>
                                    <span>Cat. Dispositivos</span>
                                </a>
                            </li>
                            <li class="item menu-item menu-item-static">
                                <a href="/ProyectoPandora/Public/index.php?route=Inventario/ListarCategorias" class="link flex">
                                    <i class='bx bx-purchase-tag'></i>
                                    <span>Cat. Inventario</span>
                                </a>
                            </li>
                        <?php elseif ($role === 'supervisor'): ?>
                            <li class="item menu-item-static">
                                <a href="index.php?route=Supervisor/Asignar" class="link flex">
                                    <i class='bxr  bx-ticket'></i>
                                    <span>Supervisor</span>
                                </a>
                            </li>
                        <?php elseif ($role === 'tecnico'): ?>
                            <!-- Técnico: solo ve Reparaciones y tickets -->
                            <li class="item menu-item-static">
                                <a href="index.php?route=Tecnico/MisReparaciones" class="link flex">
                                    <i class='bxr  bx-ticket'></i>
                                    <span>Técnico</span>
                                </a>
                            </li>
                        <?php elseif ($role === 'cliente'): ?>
                            <li class="item menu-item-static">
                                <a href="index.php?route=Cliente/MisDevice" class="link flex">
                                    <i class='bx  bx-devices'></i>
                                    <span>Cliente</span>
                                </a>
                            </li>
                        <?php endif; ?>
                    <?php else: ?>
                        <!-- No logueado -->
                        <!-- Iniciar sesion, Registro y Guia -->
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
                        <li class="item ">
                            <a href="/ProyectoPandora/Public/index.php?route=Default/Guia" class="link flex">
                                <i class='bx  bx-help-circle'></i>
                                <span>Guia</span>
                                </i>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>
    </aside>
</body>
</html>