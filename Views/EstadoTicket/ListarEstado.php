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
                <a class="btn-acciones-user" href="/ProyectoPandora/Public/index.php?route=EstadoTicket/Crear">Añadir Estado</a>
            </div>
        </div>
        <h2>Lista de Estados</h2>
        <div class="search-container">
            <input type="text" id="userSearchInput" placeholder="Buscar usuario..." class="search-input">
        </div>
        <table id="userTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre del Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($estados as $estado): ?>
                <tr>
                    <td><?php echo htmlspecialchars($estado['id']); ?></td>
                    <td><?php echo htmlspecialchars($estado['name']); ?></td>
                    <td>
                        <div class='action-buttons'>
                            <a href="/ProyectoPandora/Public/index.php?route=EstadoTicket/Editar&id=<?php echo $estado['id']; ?>" class="btn edit-btn">Actualizar</a>
                            |
                            <a href="/ProyectoPandora/Public/index.php?route=EstadoTicket/Eliminar&id=<?php echo $estado['id']; ?>" class="btn delete-btn">Eliminar</a>
                        </div>
                    </td>
                </tr>
                <?php endforeach;
                    if (empty($estados)): ?>
                    <tr>
                        <td colspan="3">No hay estados disponibles.</td>
                    </tr>
                    <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>
<?php include_once __DIR__ . '/../Includes/Footer.php' ?>