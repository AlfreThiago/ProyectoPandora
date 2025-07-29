<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Configuraciones básicas para que la página se vea bien en todos los dispositivos -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>
    
    <!-- Estilos específicos para el encabezado -->
    <link rel="stylesheet" href="/ProyectoPandora/Public/css/AddHeader.css">
</head>

<body>
    <!-- es un Botón que aparece flotando para abrir o cerrar el menú lateral -->
    <div class="menu-btn sidebar-btn" id="sidebar-btn">
        <i class='bx bx-menu-wider'></i>
        <i class='bx bx-x'></i>
    </div>

    <!-- Es el menú lateral del dashboard -->
    <div class="sidebar" id="sidebar">

        <!-- Es la parte de arriba del menu lateral: logo y botón para contraer -->
        <div class="header">
            <div class="menu-btn" id="menu-btn">
                <i class='bx bx-arrow-left'></i>
            </div>
            <div class="brand">
                <!-- Son dos versiones del logo para cambiar el tema claro o oscuro -->
                <img class="brand-light" src="img/Innovasys_V2.png" alt="logo">
                <img class="brand-dark" src="img/Innovasys_V2.png" alt="logo">
                <span></span>
            </div>
        </div>

        <!-- Opciones del menú que el usuario puede elegir -->
        <div class="menu-conteiner">
            <ul class="menu">

                <!-- Opción para ir al inicio del panel -->
                <li class="menu-item menu-item-static active">
                    <a href="/ProyectoPandora/Public/index.php?route=Dash/Home" class="menu-link">
                        <i class='bx bx-home'></i>
                        <span>Home</span>
                    </a>
                </li>
                <li class="menu-item menu-item-static active">
                    <a href="index.php?route=Dash/Admin" class="menu-link">
                        <i class='bx bx-user'></i>
                        <span>Volver</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Parte de abajo del menú con accesos rápidos y el usuario que está usando el sistema -->
        <div class="footer">
            <ul class="menu">
                <li class="menu-item menu-item-static">
                    <a href="#" class="menu-link">
                        <i class='bx bx-bell-minus'></i>
                        <span>Notificaciones</span>
                    </a>
                </li>
                <li class="menu-item menu-item-static">
                    <a href="#" class="menu-link">
                        <i class='bx bx-bell-minus'></i>
                        <span>Ajustes</span>
                    </a>
                </li>
            </ul>

            <!-- Muestra el nombre y correo del usuario conectado -->
            <div class="user">
                <div class="user-data">
                    <span class="name">
                        <?php echo isset($_SESSION['user']['name']) ? htmlspecialchars($_SESSION['user']['name']) : 'Usuario'; ?>
                    </span>
                    <span class="email">
                        <?php echo isset($_SESSION['user']['email']) ? htmlspecialchars($_SESSION['user']['email']) : 'correo@ejemplo.com'; ?>
                    </span>
                </div>

                <!-- Es el icono para cerrar la sesión -->
                <div class="user-icon">
                    <a href="/ProyectoPandora/Public/index.php?route=Auth/Logout">
                        <i class='bx bx-arrow-out-right-square-half'></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Script que hace funcionar el menú de la izquierda -->
    <script>
        const MenuItemDropdown = document.querySelectorAll(".menu-item-dropdown");
        const MenuItemStatic = document.querySelectorAll(".menu-item-static");
        const sidebar = document.getElementById("sidebar");
        const menuBtn = document.getElementById("menu-btn");

        // Abre o cierra el menú lateral al pulsar el botón
        menuBtn.addEventListener("click", () => {
            sidebar.classList.toggle("minimize");
        });

        // Hace que los submenús se abran o cierren según la interacción
        MenuItemDropdown.forEach((menuItem) => {
            menuItem.addEventListener("click", () => {
                const subMenu = menuItem.querySelector(".sub-menu");
                const isActive = menuItem.classList.toggle("sub-menu-toggle");

                if (subMenu) {
                    subMenu.style.height = isActive ? `${subMenu.scrollHeight + 6}px` : "0";
                    subMenu.style.padding = isActive ? "0.2rem 0" : "0";
                }

                // Cierra los otros submenús si este se abre
                MenuItemDropdown.forEach((item) => {
                    if (item !== menuItem) {
                        const otherSubmenu = item.querySelector(".sub-menu");
                        if (otherSubmenu) {
                            item.classList.remove("sub-menu-toggle");
                            otherSubmenu.style.height = "0";
                            otherSubmenu.style.padding = "0";
                        }
                    }
                });
            });
        });

        // Si el menú está minimizado y pasás el mouse por otro ítem, se cierran los submenús
        MenuItemStatic.forEach((menuItem) => {
            menuItem.addEventListener("mouseenter", () => {
                if (!sidebar.classList.contains("minimize")) return;

                MenuItemDropdown.forEach((item) => {
                    const otherSubmenu = item.querySelector(".sub-menu");
                    if (otherSubmenu) {
                        item.classList.remove("sub-menu-toggle");
                        otherSubmenu.style.height = "0";
                        otherSubmenu.style.padding = "0";
                    }
                });
            });
        });

        // Restablece el estado del menú lateral cuando cambia el tamaño de la ventana
        function checkWindowsSize() {
            sidebar.classList.remove("minimize");
        }
        checkWindowsSize();
        window.addEventListener("resize", checkWindowsSize);
    </script>

</body>
