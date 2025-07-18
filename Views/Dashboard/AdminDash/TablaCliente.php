<head>
    <link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>
</head>
<main>
    <div class="Tabla-Contenedor">
        <h2>Clientes</h2>
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
                    $clientes = $userModel->getAllClientes();
                    if ($clientes) {
                        foreach ($clientes as $cliente) {
                            $role = htmlspecialchars($cliente['role']);
                            echo "<tr class='row-role-$role'>";
                            echo "<td>{$cliente['id']}</td>";
                            echo "<td>{$cliente['name']}</td>";
                            echo "<td>{$cliente['email']}</td>";
                            echo "<td><span class='role $role'>$role</span></td>";
                            echo "<td><span class='created-at'>🕒 " . htmlspecialchars($cliente['created_at']) . "</span></td>";
                            echo "<td>
                                <a href='/ProyectoPandora/Public/index.php?route=Admin/Edit-user&id={$cliente['id']}' class='btn edit-btn'>Editar</a>
                                <a href='/ProyectoPandora/Public/index.php?route=Admin/Delete-user&id={$cliente['id']}' class='btn delete-btn'>Eliminar</a>
                            </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No hay clientes registrados.</td></tr>";
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
    document.addEventListener("DOMContentLoaded", function() {
        const input = document.getElementById("userSearchInput");
        input.addEventListener("input", function() {
            const searchTerm = input.value.toLowerCase();
            const rows = document.querySelectorAll("#userTable tbody tr");
            rows.forEach(row => {
                const rowText = row.textContent.toLowerCase();
                row.style.display = rowText.includes(searchTerm) ? "" : "none";
            });
        });

        const darkModeBtn = document.getElementById("dark-mode-btn");
        darkModeBtn.addEventListener("click", () => {
            document.body.classList.toggle("dark-mode");
        });
    });
</script>
