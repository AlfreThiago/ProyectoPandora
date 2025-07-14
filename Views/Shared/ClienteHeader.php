<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/ProyectoPandora/Public/css/ClienteDash.css">
</head>

<body>
    <header class="cliente-header">
        <div class="dash-conteiner">
            
            <h2>
                <?php
            if (isset($_SESSION['user'])) {
                echo 'Bienvenido, ' . htmlspecialchars($_SESSION['user']['name']);
            } else {
                echo 'Por favor, inicie sesión.';
            }
            ?>
            </h2>
            </div>
            <br>
            <div class="header-derecha">
                <a href="/ProyectoPandora/Public/index.php?route=Dash/Home" class="home-btn">home</a>
                <a href="/ProyectoPandora/Public/index.php?route=Auth/Logout" class="logout-btn">Cerrar Sesion</a>
            </div>
</header>
</body>

</html>