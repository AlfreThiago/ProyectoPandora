<head>
    <link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="/ProyectoPandora/Public/css/supervisores.css">
</head>

<main>
    <div class="Tabla-Contenedor">
        <h2>Supervisores</h2>
        <div class="search-container">
            <input type="text" id="userSearchInput" placeholder="Buscar usuario..." class="search-input">
        </div>
        <table id="userTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Roles</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $db = new Database();
                $db->connectDatabase();
                $userModel = new UserModel($db->getConnection());
                $supervisor = $userModel->getAllSupervisores();
                if ($supervisor) {
                    foreach ($supervisor as $super) {
                        $role = htmlspecialchars($super['role']);
                        echo "<tr class='row-role-$role'>";
                        echo "<td>{$super['id']}</td>";
                        echo "<td>{$super['name']}</td>";
                        echo "<td>{$super['email']}</td>";
                        echo "<td><span class='role $role'>$role</span></td>";
                        echo "<td><span class='created-at'>🕒 " . htmlspecialchars($super['created_at']) . "</span></td>";
                        echo "<td>
                            <a href='/ProyectoPandora/Public/index.php?route=Admin/Edit-user&id={$super['id']}' class='btn edit-btn'>Editar</a>
                            <a href='/ProyectoPandora/Public/index.php?route=Admin/Delete-user&id={$super['id']}' class='btn delete-btn'>Eliminar</a>
                        </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No hay supervisores registrados.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <div class="dark-mode-btn" id="dark-mode-btn">
        <i class='bx bx-sun'></i>
        <i class='bx bx-moon'></i>
    </div>
</main>

<script>
    // Filtro de búsqueda
    document.addEventListener("DOMContentLoaded", function () {
        const input = document.getElementById("userSearchInput");
        input.addEventListener("input", function () {
            const searchTerm = input.value.toLowerCase();
            const rows = document.querySelectorAll("#userTable tbody tr");
            rows.forEach(row => {
                const rowText = row.textContent.toLowerCase();
                row.style.display = rowText.includes(searchTerm) ? "" : "none";
            });
        });
    });

    // Modo oscuro/claro
    const darkModeBtn = document.getElementById("dark-mode-btn");
    darkModeBtn.addEventListener("click", () => {
        document.body.classList.toggle("dark-mode");
    });
</script>
