<?php
require_once __DIR__ . '/../../Routes/web.php';
?>

<head>
    <link rel="stylesheet" href="/ProyectoPandora/Public/css/StyleAuth.css">
    <link rel="stylesheet" href="https://unpkg.com/pushbar.js@1.0.0/dist/pushbar.css">
</head>
<header>
    <div class="conteiner">
        <nav>
            <a href="/ProyectoPandora/Public/index.php?route=Auth/Login">Iniciar sesión</a>
                <br>
            <a href="/ProyectoPandora/Public/index.php?route=Register/Register">Registrarse</a>
        </nav>
    </div>
</header>