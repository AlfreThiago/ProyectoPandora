<main>
    <div class="Tabla-Contenedor">
        <h2>Lista de Técnicos</h2>
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
                    <th>Disponibilidad</th>
                    <th>Especialización</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $db = new Database();
                $db->connectDatabase();
                $userModel = new UserModel($db->getConnection());
                $Tecnicos = $userModel->getAllTecnicos();
                if ($Tecnicos) {
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
                        echo "<td>
                                <a href='/ProyectoPandora/Public/index.php?route=Admin/ActualizarUser&id={$tec['id']}' class='btn edit-btn'>Actualizar</a>
                                <a href='/ProyectoPandora/Public/index.php?route=Admin/Delete-user&id={$tec['id']}' class='btn delete-btn'>Eliminar</a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No hay técnicos registrados.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <div class="dark-mode-btn" id="dark-mode-btn">
        <i class='bx bx-sun'></i>
        <i class='bx bx-moon'></i>
    </div>
    <script src="/ProyectoPandora/Public/js/Buscador.js"></script>
</main>