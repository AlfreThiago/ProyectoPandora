function showTab(tab) {
            document.querySelectorAll('.tab').forEach(el => el.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(el => el.style.display = 'none');
            document.querySelector(`[onclick="showTab('${tab}')"]`).classList.add('active');
            document.getElementById(tab).style.display = 'block';
        }

function filterTable(role) {
    const rows = document.querySelectorAll("#userTable tbody tr");
    rows.forEach(row => {
        const cellRole = row.querySelector("td:nth-child(4) .role");
            if (role === "all" || (cellRole && cellRole.textContent.trim() === role)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    }
function showDeviceTable(type) {
    const dispositivos = document.getElementById("dispositivosTable");
    const categorias = document.getElementById("categoriasTable");

    if (type === "categorias") {
        categorias.style.display = "table";
        dispositivos.style.display = "none";
    } else {
        categorias.style.display = "none";
        dispositivos.style.display = "table";
    }
}
function mostrarDescripcion(select) {
    let descripcion = select.options[select.selectedIndex].getAttribute('data-descripcion');
    document.getElementById('descripcion').value = descripcion || "";
}
