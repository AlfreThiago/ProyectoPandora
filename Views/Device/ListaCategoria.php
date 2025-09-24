<?php include_once __DIR__ . '/../Includes/Sidebar.php'; ?>
<main>
<?php include_once __DIR__ . '/../Includes/Header.php'; ?>
    <div class="Tabla-Contenedor">
        <h2>Lista de Categorías</h2>
        <div class="botones">
            <div class="btn-table-acciones">
                <a class="btn-acciones-cate" href="/ProyectoPandora/Public/index.php?route=Device/CrearCategoria">Añadir Categoria</a>
            </div>
        </div>
        <table id="categoryTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre de la Categoría</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categorias as $categoria): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($categoria['id']); ?></td>
                        <td><?php echo htmlspecialchars($categoria['name']); ?></td>
                        <td>
                            <div class='action-buttons'>
                                <a href="/ProyectoPandora/Public/index.php?route=Device/ActualizarCategoria&id=<?php echo $categoria['id']; ?>" class="btn edit-btn">Actualizar</a>
                                |
                                <a href="/ProyectoPandora/Public/index.php?route=Device/Delete-Category&id=<?php echo $categoria['id']; ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar esta categoría?');" class="btn delete-btn">Eliminar</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($categorias)): ?>
                    <tr>
                        <td colspan="3">No hay categorías disponibles.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="dark-mode-btn" id="dark-mode-btn">
        <i class='bx bx-sun'></i>
        <i class='bx bx-moon'></i>
    </div>
    <script src="/ProyectoPandora/Public/js/Buscador.js"></script>
</main>