<!DOCTYPE html>
<html lang="es">

<head>
<!-- Código básico para que la pagina se vea y funcione bien en celulares y PC-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Estilos específicos para el panel de técnicos -->
    <link rel="stylesheet" href="/ProyectoPandora/Public/css/TecnicoDash.css">
    <link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>
</head>

<body>

  <!--  va toda la información y contenido principal del panel -->
    <!-- <div class="dash-conteiner">

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
            <!-- Es el botón para cerrar la sesión 
            <a href="/ProyectoPandora/Public/index.php?route=Auth/Logout">Cerrar Sesion</a>
        </h2>
    </div> -->
        
    
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
                <li class="menu-item menu-item-static">
                    <a href="/ProyectoPandora/Public/index.php?route=Dash/Home" class="menu-link">
                        <i class='bx bx-home'></i>
                        <span>Home</span>
                    </a>
                </li>
                <li class="menu-item menu-item-static">
                    <a href="/ProyectoPandora/Public/index.php?route=Auth/Login" class="menu-link">
                        <i class='bx bx-arrow-out-right-square-half'></i>
                        <span>Iniciar Sesión</span>
                    </a>
                </li>
                <li class="menu-item menu-item-static">
                    <a href="/ProyectoPandora/Public/index.php?route=Register/Register" class="menu-link">
                        <i class='bxr  bx-form'  ></i> 
                        <span>Registrarse</span>
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
                        <i class='bxr  bx-cog'  ></i> 
                        <span>Ajustes</span>
                    </a>
                </li>
            </ul>
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
 const menuBtn = document.getElementById('menu-btn');
  menuBtn.addEventListener('click', () => {
    document.body.classList.toggle('sidebar-expanded');
  });
    </script>



</body>

</html>
