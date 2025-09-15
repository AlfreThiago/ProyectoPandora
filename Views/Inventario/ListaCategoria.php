<?php include_once __DIR__ . '/../Includes/Sidebar.php'; ?>

<main>
    <div class="Contenedor">
        <section class="Conenedor-formulario-principal">
            <h2>Categorías de Inventario</h2>
            <div class="botones">
                <a class="btn-acciones-inventario" href="/ProyectoPandora/Public/index.php?route=Inventario/MostrarCrearCategoria">Añadir Categoría</a>
            </div>
            <table>
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
        </section>
    </div>
</main>
<?php include_once __DIR__ . '/../Includes/Footer.php' ?>