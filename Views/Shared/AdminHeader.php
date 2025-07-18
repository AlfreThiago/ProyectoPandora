<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/ProyectoPandora/Public/css/AdminDash.css">
</head>

<body>

    <div class="menu-btn sidebar-btn" id="sidebar-btn">
        <i class='bx  bx-menu-wider'  ></i> 
        <i class='bx  bx-x'  ></i> 
    </div>
    <div class="sidebar" id="sidebar">
        <div class="header">
            <div class="menu-btn" id="menu-btn">
                <i class='bx  bx-arrow-left'  ></i> 
            </div>
             <div class="brand">
               <img class="brand-light" src="img/LogoSinFondo.png" alt="logo">
               <img class="brand-dark" src="img/Logo.png" alt="logo">
                <span>Hefesto</span>
               </div>
        </div>
        <div class="menu-conteiner">
            <ul class="menu">
                <li class="menu-item menu-item-static active">
                    <a href="/ProyectoPandora/Public/index.php?route=Dash/Home" class="menu-link">
                        <i class='bx  bx-home'  ></i> 
                        <span>Home</span>
                    </a>
                </li>
                <li class="menu-item menu-item-dropdown">
                    <a href="#" class="menu-link">
                        <i class='bx  bx-user'  ></i> 
                        <span>Usuarios</span>
                        <i class='bx  bx-arrow-down-stroke'  ></i> 
                    </a>
                    <ul class="sub-menu">
                        <li><a href="/ProyectoPandora/Public/index.php?route=Dash/TablaCliente" class="sub-menu-link">Clientes</a></li>
                        <li><a href="/ProyectoPandora/Public/index.php?route=Dash/TablaTecnico" class="sub-menu-link">Tecnicos</a></li>
                        <li><a href="/ProyectoPandora/Public/index.php?route=Dash/TablaSupervisor" class="sub-menu-link">Supervisor</a></li>
                        <li><a href="/ProyectoPandora/Public/index.php?route=Dash/TablaAdmin" class="sub-menu-link">Admins</a></li>
                    </ul>
                </li>
                <li class="menu-item menu-item-static">
                    <a href="/ProyectoPandora/Public/index.php?route=Register/RegisterAdminPortal" class="menu-link">
                        <i class='bx  bx-plus-square'  ></i> 
                        <span>Añadir</span>
                    </a>
                </li>
        </ul>
        </div>
            <div class="footer">
            <ul class="menu">
                <li class="menu-item menu-item-static">
                    <a href="#" class="menu-link">
                        <i class='bx  bx-bell-minus'  ></i> 
                        <span>Notification</span>
                    </a>
                </li>
                <li class="menu-item menu-item-static">
                    <a href="#" class="menu-link">
                        <i class='bx  bx-bell-minus'  ></i> 
                        <span>setting</span>
                    </a>
                </li>
            </ul>
            <div class="user">
                <div class="user-data">
                    <span class="name">
                        <?php echo isset($_SESSION['user']['name']) ? htmlspecialchars($_SESSION['user']['name']) : 'Usuario'; ?>
                    </span>
                    <span class="email">
                        <?php echo isset($_SESSION['user']['email']) ? htmlspecialchars($_SESSION['user']['email']) : 'correo@ejemplo.com'; ?>
                    </span>
                </div>
                <div class="user-icon">
                    <a href="/ProyectoPandora/Public/index.php?route=Auth/Logout">
                        <i class='bx bx-arrow-out-right-square-half'></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    </div>
<script>
    const MenuItemDropdown = document.querySelectorAll(".menu-item-dropdown");
    const MenuItemStatic = document.querySelectorAll(".menu-item-static");
    const sidebar = document.getElementById("sidebar");
    const menuBtn = document.getElementById("menu-btn");

        menuBtn.addEventListener("click", () => {
            sidebar.classList.toggle("minimize");
        });

        MenuItemDropdown.forEach((menuItem) => {
            menuItem.addEventListener("click", () => {
                const subMenu = menuItem.querySelector(".sub-menu");
                const isActive = menuItem.classList.toggle("sub-menu-toggle");

                if (subMenu) {
                    subMenu.style.height = isActive ? `${subMenu.scrollHeight + 6}px` : "0";
                    subMenu.style.padding = isActive ? "0.2rem 0" : "0";
                }

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

        function checkWindowsSize() {
            sidebar.classList.remove("minimize");
        }
        checkWindowsSize();
        window.addEventListener("resize", checkWindowsSize);

</script>
</body>