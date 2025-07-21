<!DOCTYPE html>
<html lang="es">

<head>
<!-- Código básico para que la pagina se vea y funcione bien en celulares y PC-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Estilos específicos para el panel de técnicos -->
    <link rel="stylesheet" href="/ProyectoPandora/Public/css/TecnicoDash.css">
</head>

<body>
  <!--  va toda la información y contenido principal del panel -->
    <div class="dash-conteiner">

        <h2>
            <?php
           // Confirma si hay un usuario en logueado
            if (isset($_SESSION['user'])) {
                // Le dama la bienvenida mostrando su nombre
                echo 'Bienvenido, ' . htmlspecialchars($_SESSION['user']['name']);
            } else {
                // Si no está logueado, se le pede que inicie sesión
                echo 'Por favor, inicie sesión.';
            }
            ?>
            <br>
            <!-- Es el botón para cerrar la sesión -->
            <a href="/ProyectoPandora/Public/index.php?route=Auth/Logout">Cerrar Sesion</a>
        </h2>
    </div>
</body>

</html>
