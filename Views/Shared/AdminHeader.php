<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/ProyectoPandora/Public/css/AdminDash.css">
</head>

<body>
    <header class="admin-header">
        <div class="header-izquierda">
            <?php
            if (isset($_SESSION['user'])) {
                echo '<h2>Bienvenido, ' . htmlspecialchars($_SESSION['user']['name']) . '</h2>';
            } else {
                echo '<h2>Por favor, inicie sesión.</h2>';
            }
            ?>
        </div>
        <div class="header-derecha">
            <a href="/ProyectoPandora/Public/index.php?route=Auth/Logout" class="logout-btn">Cerrar sesión</a>
            <a href="/ProyectoPandora/Public/index.php?route=Dash/Home" class="logout-btn"> Home </a>
        </div>
    </header>
</body>

</html>