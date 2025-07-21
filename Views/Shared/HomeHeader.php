<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Configuración básica del documento -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Estilos para la página principal -->
    <link rel="stylesheet" href="/ProyectoPandora/Public/css/StyleHome.css">
    <title>Home Portal</title>
</head>

<body>
    <!-- Header principal del portal -->
    <header class="home-header">
        <!-- Logo alineado a la izquierda -->
        <div class="header-left">
            <img src="/ProyectoPandora/Public/img/LogoSinFondo.png" class="header-logo" alt="Logo">
        </div>

        <!-- Título centrado -->
        <div class="header-title">
            <h1>Home Portal</h1>
        </div>

        <!-- Menú de navegación a la derecha -->
        <div class="header-right">
            <nav>
                <ul>
                    <?php if (!isset($user) || !$user): ?>
                        <!-- Si el usuario no está logueado, mostramos opciones para entrar o registrarse -->
                        <li><a href="index.php?route=Auth/Login" class="btn">Iniciar Sesión</a></li>
                        <li><a href="index.php?route=Register/Register" class="btn">Registrarse</a></li>
                    <?php else: ?>
                     <!-- Si un usuario está logueado, mostramos su correo y rol y opciones según su perfil -->
                        <div class="user-action">
                            <li>
                                <p>Hola, <?= htmlspecialchars($user['email']) ?> (<?= htmlspecialchars($user['role']) ?>)</p>
                            </li>
                            <div class="botones">
                                <?php if ($user['role'] === 'Administrador'): ?>
                                    <li><a href="index.php?route=Dash/Admin" class="admin">Ir al Panel de Administrador</a></li>
                                <?php elseif ($user['role'] === 'Supervisor'): ?>
                                    <li><a href="index.php?route=Dash/Supervisor" class="super">Ir al Panel de Supervisor</a></li>
                                <?php elseif ($user['role'] === 'Tecnico'): ?>
                                    <li><a href="index.php?route=Dash/Tecnico" class="tec">Ir al Panel de Técnico</a></li>
                                <?php elseif ($user['role'] === 'Cliente'): ?>
                                    <li><a href="index.php?route=Dash/Cliente" class="cliente">Ir al Panel de Cliente</a></li>
                                <?php endif; ?>
                                <!-- Es el enlace para cerrar sesión -->
                                <li><a href="index.php?route=Auth/Logout" class="logout">Cerrar sesión</a></li>
                            </div>
                        </div>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>
