<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/ProyectoPandora/Public/css/StyleHome.css">
    <title>Home Portal</title>
</head>

<body>
    <header class="header">
        <div class="header-left">
            <img src="/ProyectoPandora/Public/img/LogoSinFondo.png" class="header-logo" alt="Logo">
        </div>
        <div class="header-title">
            <h1>Home Portal</h1>
        </div>
        <div class="header-right">
            <nav class="header-nav">
                <ul>
                    <?php if (!isset($user) || !$user): ?>
                        <li><a href="index.php?route=Auth/Login">Iniciar Sesión</a></li>
                        <li><a href="index.php?route=Register/Register">Registrarse</a></li>
                    <?php else: ?>
                        <li>
                            <p>Hola, <?= htmlspecialchars($user['email']) ?> (<?= htmlspecialchars($user['role']) ?>)</p>
                        </li>
                        <?php if ($user['role'] === 'Administrador'): ?>
                            <li><a href="index.php?route=Dash/Admin">Ir al Panel de Administrador</a></li>
                        <?php elseif ($user['role'] === 'Supervisor'): ?>
                            <li><a href="index.php?route=Dash/Supervisor">Ir al Panel de Supervisor</a></li>
                        <?php elseif ($user['role'] === 'Tecnico'): ?>
                            <li><a href="index.php?route=Dash/Tecnico">Ir al Panel de Técnico</a></li>
                        <?php elseif ($user['role'] === 'Cliente'): ?>
                            <li><a href="index.php?route=Dash/Cliente">Ir al Panel de Cliente</a></li>
                        <?php endif; ?>
                        <li><a href="index.php?route=Auth/Logout">Cerrar sesión</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>