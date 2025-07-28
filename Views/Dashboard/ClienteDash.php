<head>
  <link rel="stylesheet" href="/ProyectoPandora/Public/css/ClienteDash.css">
</head>
<body>
<div class="ContenedorPrincipal">
   <!-- Encabezado principal del panel para clientes -->
  <h2>Panel del Cliente</h2>

  <div class="panel-opciones">
    <!-- Link para ver el técnico asignado al cliente -->
    <a href="ver_tecnico_asignado.php" class="opcion">
      <h3>👨‍🔧 Técnico Asignado</h3>
      <p>Acá podés ver quién está a cargo de tus servicios.</p>
    </a>

    <!-- Link para consultar los reportes que hizo el cliente -->
    <a href="ver_reportes.php" class="opcion">
      <h3>📋 Mis Reportes</h3>
      <p>Consultá el historial de tus reportes técnicos.</p>
    </a>

    <!-- Link para enviar mensajes al equipo de soporte -->
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
        // Botón para cambiar entre modo claro y oscuro
    const darkModeBtn = document.getElementById("dark-mode-btn");
    darkModeBtn.addEventListener("click", () => {
        document.body.classList.toggle("dark-mode");
    });
  </script>
</body>