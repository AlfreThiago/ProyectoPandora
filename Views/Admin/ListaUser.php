<?php include_once __DIR__ . '/../Includes/Sidebar.php'; ?>

<?php
// Verificamos el rol logueado desde la sesión
$rol = $_SESSION['user']['role'] ?? null;

switch ($rol) {
    case 'Administrador':
        include_once __DIR__ . '/../Admin/PanelAdmin.php';
        break;
    case 'Tecnico':
        include_once __DIR__ . '/../Paneles/PanelTecnico.php';
        break;
    case 'Supervisor':
        include_once __DIR__ . '/../Paneles/PanelSupervisor.php';
        break;
    case 'Cliente':
        include_once __DIR__ . '/../Paneles/PanelCliente.php';
        break;
    default:
        echo "<p>No tienes un rol asignado o el rol no es válido.</p>";
        break;
}
?>
<main>
    <div class="Tabla-Contenedor">
        <h2>Lista de Usuarios</h2>
        <div class="botones">
            <div class="dropdown">
                <label for="menu-toggle" class="dropdown-label" >
                    Opciones<i class='bxr  bx-caret-down'  ></i> </label>
                <input type="checkbox" id="menu-toggle" />
            
                <div class="dropdown-menu">
                    <a class="btn-table" href="/ProyectoPandora/Public/index.php?route=Admin/ListarUsers">Todos</a>
                    <a class="btn-table" href="/ProyectoPandora/Public/index.php?route=Admin/ListarClientes">Clientes</a>
                    <a class="btn-table" href="/ProyectoPandora/Public/index.php?route=Admin/ListarAdmins">Admin</a>
                    <a class="btn-table" href="/ProyectoPandora/Public/index.php?route=Admin/ListarSupervisores">Supervisor</a>
                    <a class="btn-table" href="/ProyectoPandora/Public/index.php?route=Admin/ListarTecnicos">Tecnico</a>
                </div>
                
            </div>
            <div class="btn-table-acciones">
                <a class="btn-acciones-user" href="/ProyectoPandora/Public/index.php?route=Register/RegisterAdmin">Añadir Usuario</a>
            </div>
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
                        echo "<a href='/ProyectoPandora/Public/index.php?route=Admin/ActualizarUser&id=" . htmlspecialchars($user['id']) . "&from=Admin/ListarUsers' class='btn edit-btn'>Editar</a> |";
                        echo "<a href='/ProyectoPandora/Public/index.php?route=Admin/DeleteUser&id=" . htmlspecialchars($user['id']) . "' class='btn delete-btn'>Eliminar</a>";
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
</main>
    <script src="/ProyectoPandora/Public/js/Tablas.js"></script>
<?php include_once __DIR__ . '/../Includes/Footer.php' ?>