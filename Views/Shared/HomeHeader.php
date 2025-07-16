<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/ProyectoPandora/Public/css/StyleHome.css">
    <title>Home Portal</title>
</head>

<body>
    <header class="home-header">
        <div class="header-left">
            <img src="/ProyectoPandora/Public/img/LogoSinFondo.png" class="header-logo" alt="Logo">
        </div>
        <div class="header-title">
            <h1>Home Portal</h1>
        </div>
        <div class="header-right">
            <nav>
                <ul>
                    <?php if (!isset($user) || !$user): ?>
                        <li><a href="index.php?route=Auth/Login" class="btn">Iniciar Sesión</a></li>
                        <li><a href="index.php?route=Register/Register" class="btn">Registrarse</a></li>
                    <?php else: ?>
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
                                <li><a href="index.php?route=Auth/Logout" class="logout">Cerrar sesión</a></li>
                            </div>
                        </div>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>