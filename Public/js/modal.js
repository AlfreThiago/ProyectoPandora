// Mostrar/Ocultar submenú perfil
document.addEventListener("DOMContentLoaded", () => {
  const btnProfile = document.getElementById("btn-profile");
  const submenu = document.getElementById("submenu-profile");

  if (btnProfile) {
    btnProfile.addEventListener("click", () => {
      submenu.style.display = submenu.style.display === "block" ? "none" : "block";
    });

    // Cerrar si se hace clic afuera
    window.addEventListener("click", (e) => {
      if (!e.target.closest(".profile-menu")) {
        submenu.style.display = "none";
      }
    });
  }
});
document.querySelectorAll('.has-submenu > a').forEach(trigger => {
  trigger.addEventListener('click', () => {
    const parent = trigger.parentElement;
    parent.classList.toggle('open');
  });
});
document.addEventListener('DOMContentLoaded', () => {
  const loginBtn = document.getElementById('btn-login');
  const registerBtn = document.getElementById('btn-register');
  const loginModal = document.getElementById('modal-login');
  const registerModal = document.getElementById('modal-register');

  const profileBtn = document.getElementById('btn-profile');
  const profileMenu = document.getElementById('submenu-profile');

  const openModal = m => m?.classList.add('open');
  const closeModal = m => m?.classList.remove('open');

  // Abrir
  loginBtn?.addEventListener('click', () => openModal(loginModal));
  registerBtn?.addEventListener('click', () => openModal(registerModal));

  // Cerrar por X o click fuera
  [loginModal, registerModal].forEach(m => {
    m?.addEventListener('click', e => { if (e.target === m) closeModal(m); });
    m?.querySelector('.close')?.addEventListener('click', () => closeModal(m));
  });

  // ESC cierra todo
  document.addEventListener('keydown', e => {
    if (e.key === 'Escape') {
      closeModal(loginModal);
      closeModal(registerModal);
      profileMenu?.classList.remove('open');
    }
  });

  // Submenú perfil
  profileBtn?.addEventListener('click', (e) => {
    e.stopPropagation();
    profileMenu?.classList.toggle('open');
  });
  document.addEventListener('click', (e) => {
    if (!profileMenu?.contains(e.target) && e.target !== profileBtn) {
      profileMenu?.classList.remove('open');
    }
  });
});
// Scroll negrita
const header = document.getElementById("main-header");
    window.addEventListener("scroll", () => {
      if (window.scrollY > 50) {
        header.classList.add("scrolled");
      } else {
        header.classList.remove("scrolled");
      }
    });

      document.querySelectorAll('.submenu .has-submenu > a').forEach(toggle => {
    toggle.addEventListener('click', function (e) {
      e.preventDefault(); // Prevenir scroll si es # o javascript:void(0)
      const parent = this.parentElement;

      // Cerrar todos los submenús menos el actual
      document.querySelectorAll('.submenu .has-submenu').forEach(item => {
        if (item !== parent) {
          item.classList.remove('open');
        }
      });

      // Alternar clase open
      parent.classList.toggle('open');
    });
  });
    // Control de submenús anidados
  document.querySelectorAll('.submenu .has-submenu > a').forEach(toggle => {
    toggle.addEventListener('click', function (e) {
      e.preventDefault();
      const parent = this.parentElement;

      // Cierra todos los demás
      document.querySelectorAll('.submenu .has-submenu').forEach(item => {
        if (item !== parent) item.classList.remove('open');
      });

      parent.classList.toggle('open');
    });
  });
document.addEventListener("DOMContentLoaded", function() {
  const tabs = document.querySelectorAll(".tabs a"); 
  const gif = document.querySelector(".gif");

  // Mostrar el gif solo si estamos en el panel principal
const urlParams = new URLSearchParams(window.location.search);
const route = urlParams.get('route');

if (gif) {
  if (
    !route ||
    route === "Admin/PanelAdmin" ||
    route === "Clientes/PanelCliente" ||
    route === "Paneles/PanelTecnico" ||
    route === "Paneles/PanelSupervisor"
  ) {
    gif.style.display = "block";
  } else {
    gif.style.display = "none";
  }
}

  // Ocultar el gif al hacer clic en cualquier tab
  tabs.forEach(tab => {
    tab.addEventListener("click", () => {
      if (gif) gif.style.display = "none";
    });
  });
});