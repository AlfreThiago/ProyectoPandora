<head>
  <link rel="stylesheet" href="/ProyectoPandora/Public/css/ClienteDash.css">
</head>
<body>
<div class="ContenedorPrincipal">
  
  <h2>Panel del Cliente</h2>

  <div class="panel-opciones">
  
    <a href="ver_tecnico_asignado.php" class="opcion">
      <h3>👨‍🔧 Técnico Asignado</h3>
      <p>Acá podés ver quién está a cargo de tus servicios.</p>
    </a>

    
    <a href="ver_reportes.php" class="opcion">
      <h3>📋 Mis Reportes</h3>
      <p>Consultá el historial de tus reportes técnicos.</p>
    </a>

   
    <a href="contacto.php" class="opcion">
      <h3>📨 Soporte</h3>
      <p>Mandá un mensaje directo al soporte cuando lo necesites.</p>
    </a>
  </div>
</div>
<div class="dark-mode-btn" id="dark-mode-btn">
        <i class='bx bx-sun'></i> 
        <i class='bx bx-moon'></i> 
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
       
    const darkModeBtn = document.getElementById("dark-mode-btn");
    darkModeBtn.addEventListener("click", () => {
        document.body.classList.toggle("dark-mode");
    });
  </script>
</body>