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
    <?php $adminCssPath = rtrim($_SERVER['DOCUMENT_ROOT'],'/\\') . '/ProyectoPandora/Public/css/AdminDash.css'; ?>
    <link rel="stylesheet" href="/ProyectoPandora/Public/css/AdminDash.css?v=<?= file_exists($adminCssPath) ? filemtime($adminCssPath) : time(); ?>">
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
                    <?php 
                        $user = $_SESSION['user'] ?? null;
                        $name = $user['name'] ?? '';
                        $email = $user['email'] ?? '';
                        $avatar = $user['img_perfil'] ?? '';
                        $defaultAvatar = '/ProyectoPandora/Public/img/imgPerfil/default.png';
                        if ($avatar && strpos($avatar, '/ProyectoPandora/') !== 0) {
                            $avatar = '/ProyectoPandora/Public/img/imgPerfil/' . ltrim($avatar, '/');
                        }
                        if (!$avatar) { $avatar = $defaultAvatar; }
                    ?>
                    <?php if ($user): ?>
                    <li class="item menu-item user-block">
                        <a href="/ProyectoPandora/Public/index.php?route=Default/Perfil" class="user-link">
                            <img src="<?= htmlspecialchars($avatar) ?>" alt="Perfil" class="user-avatar"/>
                            <div class="user-info">
                                <span class="user-name"><?= htmlspecialchars($name) ?></span>
                                <small class="user-email"><?= htmlspecialchars($email) ?></small>
                            </div>
                        </a>
                    </li>


                    <?php endif; ?>
                    <?php if ($user): ?>
                    <li class="item menu-item menu-item-static">
                        <a href="/ProyectoPandora/Public/index.php?route=Auth/Logout" class="link flex logout-link">
                            <i class='bx bx-log-out'></i>
                            <span>Cerrar sesión</span>
                        </a>
                    </li>
                    <?php endif; ?>
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
                            
                            <li class="item menu-item menu-item-static">
                                <a href="/ProyectoPandora/Public/index.php?route=Admin/ListarUsers" class="link flex">
                                    <i class='bx bx-user-circle'></i>
                                    <span>Usuarios</span>
                                </a>
                            </li>
                            <li class="item menu-item menu-item-static">
                                <a href="/ProyectoPandora/Public/index.php?route=Historial/ListarHistorial" class="link flex">
                                    <i class='bx bx-time'></i>
                                    <span>Historial</span>
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
                                <a href="/ProyectoPandora/Public/index.php?route=Supervisor/Asignar" class="link flex">
                                    <i class='bx bx-task'></i>
                                    <span>Asignar Técnico</span>
                                </a>
                            </li>
                            <li class="item menu-item-static">
                                <a href="/ProyectoPandora/Public/index.php?route=Supervisor/GestionInventario" class="link flex">
                                    <i class='bx bx-package'></i>
                                    <span>Gestión Inventario</span>
                                </a>
                            </li>
                            <li class="item menu-item-static">
                                <a href="/ProyectoPandora/Public/index.php?route=Supervisor/Presupuestos" class="link flex">
                                    <i class='bx bx-dollar'></i>
                                    <span>Presupuestos</span>
                                </a>
                            </li>
                        <?php elseif ($role === 'tecnico'): ?>
                            
                            <li class="item menu-item-static">
                                <a href="index.php?route=Tecnico/MisReparaciones" class="link flex">
                                    <i class='bxr  bx-ticket'></i>
                                    <span>Tickets</span>
                                </a>
                            </li>
                            <li class="item menu-item-static">
                                <a href="index.php?route=Tecnico/MisRepuestos" class="link flex">
                                    <i class='bxr  bx-ticket'></i>
                                    <span>Repuestos</span>
                                </a>
                            </li>
                            <li class="item menu-item-static">
                                <a href="index.php?route=Tecnico/MisStats" class="link flex">
                                    <i class='bxr  bx-ticket'></i>
                                    <span>Mis Stats</span>
                                </a>

                            </li>
                        <?php elseif ($role === 'cliente'): ?>
                            <li class="item menu-item-static">
                                <a href="index.php?route=Cliente/MisDevice" class="link flex">
                                    <i class='bx  bx-devices'></i>
                                    <span>Mis Dispositivos</span>
                                </a>
                            </li>
                            <li class="item menu-item-static">
                                <a href="index.php?route=Cliente/MisTicket" class="link flex">
                                    <i class='bxr  bx-ticket'></i>
                                    <span>Mis Tickets</span>
                                </a>
                            </li>
                        <?php endif; ?>
                    <?php else: ?>
                        
                        
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