<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/ProyectoPandora/Public/css/AdminDash.css">
</head>

<body>
    <div class="dash-conteiner">

        <h2>
            <?php
            if (isset($_SESSION['user'])) {
                echo 'Bienvenido, ' . htmlspecialchars($_SESSION['user']['name']);
            } else {
                echo 'Por favor, inicie sesión.';
            }
            ?>
            <br>
        </h2>
        <div>
            <ul>
                <li><a href="/ProyectoPandora/Public/index.php?route=Dash/Home">Portal</a></li>
                <li><a href="/ProyectoPandora/Public/index.php?route=Auth/Logout">Cerrar Sesion</a></li>
            </ul>
        </div>

    </div>
</body>

</html>