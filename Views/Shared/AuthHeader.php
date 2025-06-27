<?php
require_once __DIR__ . '/../../Routes/web.php';
?>

<head>
    <link rel="stylesheet" href="/ProyectoPandora/Public/css/Style.css">
    <link rel="stylesheet" href="https://unpkg.com/pushbar.js@1.0.0/dist/pushbar.css">
</head>
<div class="header">
    <nav>
        <ul>
            <li><a href="/ProyectoPandora/Public/index.php?route=Auth/Login">Iniciar sesión</a></li>
            <li><a href="/ProyectoPandora/Public/index.php?route=Register/Register">Registrarse</a></li>
        </ul>
    </nav>
</div>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .header {
        background-color: rgb(4, 3, 32);
        color: white;
        padding: 20px;
        box-sizing: border-box;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .header ul {
        list-style: none;
        display: flex;
        gap: 20px;
    }

    .header a {
        text-decoration: none;
        color: white;
    }
</style>