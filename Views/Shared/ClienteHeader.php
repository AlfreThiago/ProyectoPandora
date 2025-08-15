<head>
    
    <link rel="stylesheet" href="/ProyectoPandora/Public/css/StyleAuth.css">
    <link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>
</head>


   
    <div class="sidebar" id="sidebar">

   
        <div class="header">
            <div class="menu-btn" id="menu-btn">
                <i class='bx bx-arrow-left'></i>
            </div>
            <div class="brand">
                
                <img class="brand-light" src="img/Innovasys_V2.png" alt="logo">
                <img class="brand-dark" src="img/Innovasys_V2.png" alt="logo">
                <span></span>
            </div>
        </div>

        
        <div class="menu-conteiner">
            <ul class="menu">

               
                <li class="menu-item menu-item-static">
                    <a href="/ProyectoPandora/Public/index.php?route=Dash/Home" class="menu-link">
                        <i class='bx bx-home'></i>
                        <span>Home</span>
                    </a>
                </li>
            </ul>
        </div>

       
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
       
                        <?php echo isset($_SESSION['user']['name']) ? htmlspecialchars($_SESSION['user']['name']) : 'Usuario'; ?>
                    </span>
                    <span class="email">
                        <?php echo isset($_SESSION['user']['email']) ? htmlspecialchars($_SESSION['user']['email']) : 'correo@ejemplo.com'; ?>
                    </span>
                </div> -->
       
                <div class="user-icon logout-icon">
                    <a href="/ProyectoPandora/Public/index.php?route=Auth/Logout">
                        <i class='bxr  bx-arrow-out-left-square-half'  ></i>
                    </a>
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
          const toggleSidebar = document.getElementById('toggleSidebar');
 const menuBtn = document.getElementById('menu-btn');
  menuBtn.addEventListener('click', () => {
    document.body.classList.toggle('sidebar-expanded');
  });
    </script>
