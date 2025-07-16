<?php
require_once __DIR__ . '/../../Routes/web.php';
?>

<head>
    <link rel="stylesheet" href="/ProyectoPandora/Public/css/StyleAuth.css">
</head>

<header class="auth-header">
    <div class="header-izquierda">
        <img src="/ProyectoPandora/Public/img/LogoSinFondo.png" class="header-logo" alt="Logo">
    </div>
    <div class="header-derecha">
        <nav>
            <ul>
                <li><a href="/ProyectoPandora/Public/index.php?route=Auth/Login">Iniciar sesión</a></li>
                <li><a href="/ProyectoPandora/Public/index.php?route=Register/Register">Registrarse</a></li>
            </ul>
        </nav>
    </div>
</header>