<main>
    <?php
    // Traigo la clase para conectar con la base de datos
    include_once __DIR__ . '/../../Core/Database.php';
    ?>
    <div class="Tabla-Contenedor">
        <h2>Lista de Usuarios</h2>
        <!-- sirve para buscar usuarios en la tabla mientras escribís -->
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
                    <th>Fecha de creación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Sirve para conectarse a la base de datos
                $db = new Database();
                $db->connectDatabase();
                // traer todos los usuarios registrados
                $userModel = new UserModel($db->getConnection());
                $users = $userModel->getAllUsers();

                if ($users) {
                    // Recorre todos los usuarios y los muestro en la tabla
                    foreach ($users as $user) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($user['id']) . "</td>";
                        echo "<td>" . htmlspecialchars($user['name']) . "</td>";
                        echo "<td>" . htmlspecialchars($user['email']) . "</td>";

                        // Muestra el rol aplicando una clase para darle estilo
                        $role = htmlspecialchars($user['role']);
                        echo "<td><span class='role $role'>$role</span></td>";

                        // Fecha de creación 
                        echo "<td><span class='created-at'>🕒 " . htmlspecialchars($user['created_at']) . "</span></td>";

                        // Botones para editar o eliminar al usuario
                        echo "<td>";
                        echo "<div class='action-buttons'>";
                        echo "<a href='/ProyectoPandora/Public/index.php?route=Admin/Edit-user&id=" . htmlspecialchars($user['id']) . "' class='btn edit-btn'>Editar</a>";
                        echo "<a href='/ProyectoPandora/Public/index.php?route=Admin/Delete-user&id=" . htmlspecialchars($user['id']) . "' class='btn delete-btn'>Eliminar</a>";
                        echo "</div>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    // Aviso si no hay usuarios cargados
                    echo "<tr><td colspan='6'>No hay usuarios registrados.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Botón para activar o desactivar el modo oscuro -->
    <div class="dark-mode-btn" id="dark-mode-btn">
        <i class='bx bx-sun'></i>
        <i class='bx bx-moon'></i>
    </div>
    <script src="/ProyectoPandora/Public/js/Buscador.js"></script>
</main>