<head>
     <!-- CSS exclusivo para la parte de autenticación (login/registro) -->
    <link rel="stylesheet" href="/ProyectoPandora/Public/css/StyleAuth.css">
</head>

<!-- Encabezado común para las páginas de autenticación -->
<header class="auth-header">
    <div class="header-izquierda">

        <!-- Se muesra el logo de la aplicación -->
        <img src="/ProyectoPandora/Public/img/LogoSinFondo.png" class="header-logo" alt="Logo">
    </div>
    <div class="header-derecha">

        <!-- Son los enlaces de navegación para iniciar sesión o registrarse -->
        <nav>
            <ul>
                <li><a href="/ProyectoPandora/Public/index.php?route=Auth/Login">Iniciar sesión</a></li>
                <li><a href="/ProyectoPandora/Public/index.php?route=Register/Register">Registrarse</a></li>
            </ul>
        </nav>
    </div>
</header>
