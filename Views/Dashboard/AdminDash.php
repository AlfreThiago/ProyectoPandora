<?php
include_once __DIR__ . '/../../Core/Database.php';
?>
<div class="Tabla-Contenedor">
    <div class="search-container">
        <input type="text" id="userSearchInput" placeholder="Buscar usuario..." class="search-input">
    </div>
    <table id="userTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Rol</th>
                <th>Tiempo de Creación</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $db = new Database();
            $db->conectDatabase();
            $userModel = new UserModel($db->getConnection());
            $users = $userModel->getAllUsers();
            if ($users) {
                foreach ($users as $user) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($user['id']) . "</td>";
                    echo "<td>" . htmlspecialchars($user['name']) . "</td>";
                    echo "<td>" . htmlspecialchars($user['email']) . "</td>";
                    $role = htmlspecialchars($user['role']);
                    echo "<td><span class='role $role'>$role</span></td>";
                    echo "<td><span class='created-at'>🕒 " . htmlspecialchars($user['created_at']) . "</span></td>";
                    echo "<td>";
                    echo "<div class='action-buttons'>";
                    echo "<a href='/ProyectoPandora/Public/index.php?route=Admin/Edit-user&id=" . htmlspecialchars($user['id']) . "' class='btn edit-btn'>Editar</a>";
                    echo "<a href='/ProyectoPandora/Public/index.php?route=Admin/Delete-user&id=" . htmlspecialchars($user['id']) . "' class='btn delete-btn'>Eliminar</a>";
                    echo "</div>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No hay usuarios registrados.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
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
    });
</script>