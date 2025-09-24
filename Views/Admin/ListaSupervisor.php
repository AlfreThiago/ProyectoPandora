<?php include_once __DIR__ . '/../Includes/Sidebar.php'; ?>
<main>
<?php include_once __DIR__ . '/../Includes/Header.php'; ?>
    <div class="Tabla-Contenedor">
        <h2>Lista de Supervisores</h2>
        <div class="search-container">
            <input type="text" id="userSearchInput" placeholder="Buscar usuario..." class="search-input">
        </div>
        <div class="dropdown">
            <label for="menu-toggle" class="dropdown-label">Opciones</label>
            <input type="checkbox" id="menu-toggle" />
        
            <div class="dropdown-menu">
                <a class="btn-table" href="/ProyectoPandora/Public/index.php?route=Admin/ListarUsers">Todos</a>
                <a class="btn-table" href="/ProyectoPandora/Public/index.php?route=Admin/ListarClientes">Clientes</a>
                <a class="btn-table" href="/ProyectoPandora/Public/index.php?route=Admin/ListarAdmins">Admin</a>
                <a class="btn-table" href="/ProyectoPandora/Public/index.php?route=Admin/ListarSupervisores">Supervisor</a>
                <a class="btn-table" href="/ProyectoPandora/Public/index.php?route=Admin/ListarTecnicos">Tecnico</a>
            </div>
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
                            <div class='action-buttons'>
                                <a href='/ProyectoPandora/Public/index.php?route=Admin/ActualizarUser&id={$super['id']}&from=Admin/ListarSupers' class='btn edit-btn'>Actualizar</a>
                                |
                                <a href='/ProyectoPandora/Public/index.php?route=Admin/DeleteUser&id={$super['id']}' class='btn delete-btn'>Eliminar</a>
                            </div>
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
</main>