<main>
    <div class="Tabla-Contenedor">
        <h2>Supervisores</h2>

        <!-- sirve para buscar usuarios en la tabla mientras escribís -->
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
                // Sirve para conectarse a la base de datos
                $db = new Database();
                $db->connectDatabase();

                // Creo el modelo de usuarios usando la conexión a la base de datos
                $userModel = new UserModel($db->getConnection());

                // Traigo todos los supervisores
                $supervisor = $userModel->getAllSupervisores();

                if ($supervisor) {
                    // Muestra cada supervisor en una fila de la tabla
                    foreach ($supervisor as $super) {
                        $role = htmlspecialchars($super['role']);
                        echo "<tr class='row-role-$role'>";
                        echo "<td>{$super['id']}</td>";
                        echo "<td>{$super['name']}</td>";
                        echo "<td>{$super['email']}</td>";
                        echo "<td><span class='role $role'>$role</span></td>";
                        echo "<td><span class='created-at'>🕒 " . htmlspecialchars($super['created_at']) . "</span></td>";
                        // Botones para editar o borrar
                        echo "<td>
                            <a href='/ProyectoPandora/Public/index.php?route=Admin/Edit-user&id={$super['id']}' class='btn edit-btn'>Editar</a>
                            <a href='/ProyectoPandora/Public/index.php?route=Admin/Delete-user&id={$super['id']}' class='btn delete-btn'>Eliminar</a>
                        </td>";
                        echo "</tr>";
                    }
                } else {
                    // Si no hay supervisores, aviso con este mensaje
                    echo "<tr><td colspan='6'>No hay supervisores registrados.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Botón para cambiar entre modo oscuro y claro -->
    <div class="dark-mode-btn" id="dark-mode-btn">
        <i class='bx bx-sun'></i>
        <i class='bx bx-moon'></i>
    </div>
    <script src="/ProyectoPandora/Public/js/Buscador.js"></script>
</main>