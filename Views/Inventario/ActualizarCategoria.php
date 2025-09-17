<?php include_once __DIR__ . '/../Includes/Sidebar.php'; ?>
<main>
    <div class="Contenedor">
        <h2>Actualizar Categoría</h2>
        <form method="POST" action="/ProyectoPandora/Public/index.php?route=Inventario/EditarCategoria&id=<?= $categoria['id'] ?>">
            <input type="hidden" name="id" value="<?= $categoria['id'] ?>">
            <label for="name">Nombre de la categoría:</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($categoria['name'] ?? '') ?>" required>
            <button type="submit">Guardar cambios</button>
            <a href="/ProyectoPandora/Public/index.php?route=Inventario/ListarCategorias" class="btn btn-secondary">Volver</a>
        </form>
    </div>
</main>
<?php include_once __DIR__ . '/../Includes/Footer.php'; ?>