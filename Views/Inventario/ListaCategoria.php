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
        include_once __DIR__ . '/../Clientes/PanelCliente.php';
        break;
    default:
        echo "<p>No tienes un rol asignado o el rol no es válido.</p>";
        break;
}
?>
<main>
    <div class="Tabla-Contenedor">
            <h2>Categorías de Inventario</h2>
            <div class="botones">
                <div class="btn-table-acciones">
                    <a class="btn-acciones-inventario" href="/ProyectoPandora/Public/index.php?route=Inventario/MostrarCrearCategoria">Añadir Categoría</a>
                </div>
            </div>
            <table id="userTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($categorias)): ?>
                        <?php foreach ($categorias as $cat): ?>
                            <tr>
                                <td><?= $cat['id'] ?></td>
                                <td><?= htmlspecialchars($cat['name']) ?></td>
                                <td>
                                    <!-- Puedes agregar editar si lo implementas -->
                                    <a href="/ProyectoPandora/Public/index.php?route=Inventario/EliminarCategoriaInventario&id=<?= $cat['id'] ?>" class="btn delete-btn" onclick="return confirm('¿Seguro que deseas eliminar esta categoría?');">Eliminar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="3">No hay categorías registradas.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
    </div>
</main>
<?php include_once __DIR__ . '/../Includes/Footer.php' ?>