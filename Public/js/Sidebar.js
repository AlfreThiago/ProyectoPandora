// ====== SELECTORES ======
const sidebar = document.querySelector(".sidebar") || document.getElementById("sidebar");
const MenuItemDropdown = document.querySelectorAll(".menu-item-dropdown");

const sidebarOpenBtn = document.querySelectorAll("#sidebar-open");
const sidebarCloseBtn = document.querySelectorAll("#sidebar-close");
const sidebarLockBtn = document.querySelector("#lock-icon");

const sidebarBtn = document.getElementById("sidebar-btn");

const footer = document.querySelector(".footer");

// ====== FUNCIONES ======

// Sincroniza footer con estado del sidebar
const syncFooterClass = () => {
  if (!footer) return;

  // Limpiar clases previas
  footer.classList.remove("footer-close", "hoverable", "locked");

  // Copiar clases de estado de sidebar
  if (sidebar.classList.contains("close")) {
    footer.classList.add("footer-close");
  }
  if (sidebar.classList.contains("hoverable")) {
    footer.classList.add("hoverable");
  }
  if (sidebar.classList.contains("locked")) {
    footer.classList.add("locked");
  }
};

// Bloquear/desbloquear sidebar (modo hover)
const toggleLock = () => {
  sidebar.classList.toggle("locked");
  if (!sidebar.classList.contains("locked")) {
    sidebar.classList.add("hoverable");
    if (sidebarLockBtn) sidebarLockBtn.classList.replace("bx-lock-alt", "bx-lock-open-alt");
  } else {
    sidebar.classList.remove("hoverable");
    if (sidebarLockBtn) sidebarLockBtn.classList.replace("bxr  bx-lock", "bx bx-x");
  }
};

// Mostrar/ocultar submenús
MenuItemDropdown.forEach((menuItem) => {
  menuItem.addEventListener("click", () => {
    const subMenu = menuItem.querySelector(".sub-menu");
    const isActive = menuItem.classList.toggle("sub-menu-toggle");

    if (subMenu) {
      if (isActive) {
        subMenu.style.height = `${subMenu.scrollHeight + 6}px`;
        subMenu.style.padding = "0.2rem 0";
      } else {
        subMenu.style.height = "0";
        subMenu.style.padding = "0";
      }
    }
  });
});

// Ocultar sidebar en modo hover
const hideSidebar = () => {
  if (sidebar.classList.contains("hoverable")) {
    sidebar.classList.add("close");
    syncFooterClass();
  }
};

// Mostrar sidebar en modo hover
const showSidebar = () => {
  if (sidebar.classList.contains("hoverable")) {
    sidebar.classList.remove("close");
    syncFooterClass();
  }
};

// Toggle close/open sidebar
const toggleSidebar = () => {
  sidebar.classList.toggle("close");
  syncFooterClass();
};



// Ajustar en pantallas pequeñas
if (window.innerWidth < 800) {
  sidebar.classList.add("close");
  sidebar.classList.remove("locked", "hoverable", "minimize");
  syncFooterClass();
}

// Eventos de interacción
if (sidebarLockBtn) sidebarLockBtn.addEventListener("click", toggleLock);
if (sidebar) {
  sidebar.addEventListener("mouseleave", hideSidebar);
  sidebar.addEventListener("mouseenter", showSidebar);
}
if (sidebarOpenBtn) sidebarOpenBtn.addEventListener("click", toggleSidebar);
if (sidebarCloseBtn) sidebarCloseBtn.addEventListener("click", toggleSidebar);

// Ajuste de tamaño de ventana
function checkWindowsSize() {
  sidebar.classList.remove("minimize");
}
checkWindowsSize();
window.addEventListener("resize", checkWindowsSize);
