<?php include_once __DIR__ . '/../Includes/Header.php' ?>
<main>
    <div class="Tabla-Contenedor">
        <h2>Lista de Admins</h2>
        <div class="search-container">
            <input type="text" id="userSearchInput" placeholder="Buscar usuario..." class="search-input">
        </div>
        <table id="userTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Roles</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($administradores) {
                    foreach ($administradores as $admin) {
                        $role = htmlspecialchars($admin['role']);
                        echo "<tr class='row-role-$role'>";
                        echo "<td>{$admin['id']}</td>";
                        echo "<td>{$admin['name']}</td>";
                        echo "<td>{$admin['email']}</td>";
                        echo "<td><span class='role $role'>$role</span></td>";
                        echo "<td><span class='created-at'>🕒 " . htmlspecialchars($admin['created_at']) . "</span></td>";
                        echo "<td>
                               <a href='/ProyectoPandora/Public/index.php?route=Admin/ActualizarUser&id={$admin['id']} from=Admin/ListarAdmins' class='btn edit-btn'>Actualizar</a>
                                <a href='/ProyectoPandora/Public/index.php?route=Admin/DeleteUser&id={$admin['id']}' class='btn delete-btn'>Eliminar</a>
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
</main>
<?php include_once __DIR__ . '/../Includes/Footer.php' ?>