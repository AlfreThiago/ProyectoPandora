<main>
    <div class="Tabla-Contenedor">
        <h2>Técnicos</h2>

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
                    <th>Disponibilidad</th>
                    <th>Especialización</th>
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

                // Busco todos los usuarios con rol de técnico
                $Tecnicos = $userModel->getAllTecnicos();

                if ($Tecnicos) {
                    // Recorro y muestro cada técnico en una fila de la tabla
                    foreach ($Tecnicos as $tec) {
                        $role = htmlspecialchars($tec['role']);
                        echo "<tr class='row-role-$role'>";
                        echo "<td>{$tec['id']}</td>";
                        echo "<td>{$tec['name']}</td>";
                        echo "<td>{$tec['email']}</td>";
                        echo "<td><span class='role $role'>$role</span></td>";
                        echo "<td>{$tec['disponibilidad']}</td>";
                        echo "<td>{$tec['especialidad']}</td>";
                        echo "<td><span class='created-at'>🕒 " . htmlspecialchars($tec['created_at']) . "</span></td>";
                        // Botones para editar o borrar al técnico
                        echo "<td>
                                <a href='/ProyectoPandora/Public/index.php?route=Admin/Edit-user&id={$tec['id']}' class='btn edit-btn'>Editar</a>
                                <a href='/ProyectoPandora/Public/index.php?route=Admin/Delete-user&id={$tec['id']}' class='btn delete-btn'>Eliminar</a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    // Si no hay técnicos, aviso acá
                    echo "<tr><td colspan='8'>No hay técnicos registrados.</td></tr>";
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