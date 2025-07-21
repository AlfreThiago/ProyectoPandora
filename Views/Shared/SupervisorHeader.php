<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Sierve para que el HTML funcione en celulares-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Estilos específicos para el panel del supervisor -->
    <link rel="stylesheet" href="/ProyectoPandora/Public/css/SupervisorDash.css">
</head>

<body>
  <!-- Este es el contenedor principal donde se muestra toda la información del panel -->
    <div class="dash-conteiner">

        <h2>
            <?php
            //  se Verifica si el usuario ya inició sesión
            if (isset($_SESSION['user'])) {
                // se muestra un saludo con el nombre del usuario
                echo 'Bienvenido, ' . htmlspecialchars($_SESSION['user']['name']);
            } else {
                // Avisa si no hay nadie logueado
                echo 'Por favor, inicie sesión.';
            }
            ?>
            <br>
            <!-- Es el Link para cerrar la sesión -->
            <a href="/ProyectoPandora/Public/index.php?route=Auth/Logout">Cerrar Sesion</a>
        </h2>
    </div>
</body>

</html>
