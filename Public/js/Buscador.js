    document.addEventListener("DOMContentLoaded", function() {
        const input = document.getElementById("userSearchInput");
        input.addEventListener("input", function() {
            const searchTerm = input.value.toLowerCase();
            const rows = document.querySelectorAll("#userTable tbody tr");
            rows.forEach(row => {
                const rowText = row.textContent.toLowerCase();
                // Solo muestra las filas que coincidan con lo que buscás
                row.style.display = rowText.includes(searchTerm) ? "" : "none";
            });
        });
    });
        // Cambio el tema a oscuro o claro al hacer clic en el botón
    const darkModeBtn = document.getElementById("dark-mode-btn");
    darkModeBtn.addEventListener("click", () => {
        document.body.classList.toggle("dark-mode");
    });