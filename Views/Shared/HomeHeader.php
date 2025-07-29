<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Configuración básica del documento -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Estilos para la página principal -->
    <link rel="stylesheet" href="/ProyectoPandora/Public/css/StyleHome.css">
    <title>Home Portal</title>
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
                    <!-- Codigo para saber que rol esta inciado -->
                    <?php if (isset($_SESSION['user'])): ?>
                        <?php $role = strtolower($_SESSION['user']['role']); ?>

                        <?php if ($role === 'administrador'): ?>
                            <!-- Admin: ve todos los usuarios y opción de añadir -->
                            <li class="menu-item menu-item-dropdown">
                                <a href="#" class="menu-link">
                                    <i class='bx bx-user'></i>
                                    <span>Usuarios</span>
                                    <i class='bx bx-arrow-down-stroke'></i>
                                </a>
                                <ul class="sub-menu">
                                    <li><a href="index.php?route=Dash/Admin" class="sub-menu-link" >Todos los users</a></li>
                                    <li><a href="/ProyectoPandora/Public/index.php?route=Dash/TablaCliente" class="sub-menu-link">Clientes</a></li>
                                    <li><a href="/ProyectoPandora/Public/index.php?route=Dash/TablaTecnico" class="sub-menu-link">Técnicos</a></li>
                                    <li><a href="/ProyectoPandora/Public/index.php?route=Dash/TablaSupervisor" class="sub-menu-link">Supervisor</a></li>
                                    <li><a href="/ProyectoPandora/Public/index.php?route=Dash/TablaAdmin" class="sub-menu-link">Admins</a></li>
                                </ul>
                            </li>

                            <li class="menu-item menu-item-static">
                                <a href="/ProyectoPandora/Public/index.php?route=Register/RegisterAdminPortal" class="menu-link">
                                    <i class='bx bx-plus-square'></i>
                                    <span>Añadir</span>
                                </a>
                            </li>

                        <?php elseif ($role === 'supervisor'): ?>
                            <!-- Supervisor: ve técnicos y clientes -->
                            <li class="menu-item menu-item-dropdown">
                                <a href="#" class="menu-link">
                                    <i class='bx bx-user'></i>
                                    <span>Usuarios</span>
                                    <i class='bx bx-arrow-down-stroke'></i>
                                </a>
                                <ul class="sub-menu">
                                    <li><a href="/ProyectoPandora/Public/index.php?route=Dash/TablaCliente" class="sub-menu-link">Clientes</a></li>
                                    <li><a href="/ProyectoPandora/Public/index.php?route=Dash/TablaTecnico" class="sub-menu-link">Técnicos</a></li>
                                </ul>
                            </li>

                        <?php elseif ($role === 'tecnico'): ?>
                            <!-- Técnico: solo ve Reparaciones y tickets -->
                            <li class="menu-item menu-item-dropdown">
                                <a href="index.php?route=Dash/Tecnico" class="menu-link">
                                    <i class='bxr  bx-spanner'  ></i> 
                                    <span>Reparaciones</span>
                                </a>
                            </li>
                            <li class="menu-item menu-item-dropdown">
                                <a href="#" class="menu-link">
                                    <i class='bxr  bx-ticket'  ></i> 
                                    <span>Tickets</span>
                                </a>
                            </li>

                        <?php elseif ($role === 'cliente'): ?>
                            <li class="menu-item menu-item-dropdown">
                                <a href="index.php?route=Dash/Cliente" class="menu-link">
                                    <i class='bx bx-user'></i>
                                    <span>Clientes</span>
                                </a>
                            </li>
                        <?php endif; ?>

                    <?php else: ?>
                        <!-- No logueado -->
                        <li class="menu-item menu-item-static">
                            <a href="/ProyectoPandora/Public/index.php?route=Auth/Login" class="menu-link">
                                <i class='bx bx-arrow-out-right-square-half'></i>
                                <span>Iniciar sesión</span>
                            </a>
                        </li>
                        <li class="menu-item menu-item-static">
                            <a href="/ProyectoPandora/Public/index.php?route=Register/Register" class="menu-link">
                                <i class='bxr  bx-form'  ></i> 
                                <span>Registrarse</span>
                            </a>
                        </li>
                    <?php endif; ?>

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

            <!-- Muestra el nombre y correo del usuario conectado -->
          <div class="user">            
                <div class="user-data">
                    <?php if (isset($_SESSION['user'])): ?>
                        <div class="user-data">
                            <span class="name">
                                <?php echo isset($_SESSION['user']['name']) ? htmlspecialchars($_SESSION['user']['name']) : 'Usuario'; ?>
                            </span>
                            <span class="email">
                                <?php echo isset($_SESSION['user']['email']) ? htmlspecialchars($_SESSION['user']['email']) : 'correo@ejemplo.com'; ?>
                            </span>
                        </div>
                    <?php endif; ?>
            <!-- Mostrar esto SOLO si NO hay sesión iniciada -->
                    <?php if (!isset($_SESSION['user'])): ?>
                        <div class="profile">
                            <div class="profile-info">
                                <span class="name">Invitado</span>
                                <span class="email">Sin Sesión</span>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="user-icon logout-icon">
                        <a href="/ProyectoPandora/Public/index.php?route=Auth/Logout">
                            <i class='bxr  bx-arrow-out-left-square-half'  ></i> 
                        </a>
                    </div>
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