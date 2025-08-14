<main>
    <h2 class="LOGO">HOME PORTAL</h2>

    <!-- Botón para activar o desactivar el modo oscuro -->
    <div class="dark-mode-btn" id="dark-mode-btn">
        <i class='bx bx-sun'></i>
        <i class='bx bx-moon'></i>
    </div>
    <script>
        // Botón para cambiar entre modo claro y oscuro
        const darkModeBtn = document.getElementById("dark-mode-btn");
        darkModeBtn.addEventListener("click", () => {
            document.body.classList.toggle("dark-mode");
        });
    </script>
</main>