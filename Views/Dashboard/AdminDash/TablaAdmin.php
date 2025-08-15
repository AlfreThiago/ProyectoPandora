<main>
    <div class="Tabla-Contenedor">
        <h2>Admins</h2>

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
                    <th>Rol</th>
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

                // Traigo la lista completa de administradores
                $administradores = $userModel->getAllAdministradores();

                if ($administradores) {
                    foreach ($administradores as $admin) {
                        $role = htmlspecialchars($admin['role']);

                        // Muestro cada admini en una fila con su información
                        echo "<tr class='row-role-$role'>";
                        echo "<td>{$admin['id']}</td>";
                        echo "<td>{$admin['name']}</td>";
                        echo "<td>{$admin['email']}</td>";
                        echo "<td><span class='role $role'>$role</span></td>";
                        echo "<td><span class='created-at'>🕒 " . htmlspecialchars($admin['created_at']) . "</span></td>";

                        // Botones para editar o borrar el usuario
                        echo "<td>
                                <a href='/ProyectoPandora/Public/index.php?route=Admin/Edit-user&id={$admin['id']}' class='btn edit-btn'>Editar</a>
                                <a href='/ProyectoPandora/Public/index.php?route=Admin/Delete-user&id={$admin['id']}' class='btn delete-btn'>Eliminar</a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    // Si no hay admins, muestro este mensaje
                    echo "<tr><td colspan='6'>No hay clientes registrados.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Botón para cambiar entre modo claro y oscuro -->
    <div class="dark-mode-btn" id="dark-mode-btn">
        <i class='bx bx-sun'></i>
        <i class='bx bx-moon'></i>
    </div>
    <script src="/ProyectoPandora/Public/js/Buscador.js"></script>
</main>