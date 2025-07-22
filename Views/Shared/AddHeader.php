<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Configuraciones básicas para que la página se vea bien en todos los dispositivos -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Estilos específicos para el encabezado -->
    <link rel="stylesheet" href="/ProyectoPandora/Public/css/AddHeader.css">
</head>

<body>
    <!-- Encabezado que solo se muestra cuando el usuario es administrador -->
    <header class="admin-header">

        <!-- Acá se podría poner un logo o algo visual, por ahora está vacío -->
        <div class="header-izquierda">
        </div>

        <!-- Son Botones para navegar desde el header -->
        <div class="header-derecha">
            <!-- Te lleva al inicio del panel -->
            <a href="/ProyectoPandora/Public/index.php?route=Dash/Home" class="home-btn">Home</a>

            <!-- Cierra la sesión actual -->
            <a href="/ProyectoPandora/Public/index.php?route=Auth/Logout" class="logout-btn">Cerrar sesión</a>
        </div>
    </header>
</body>
