<?php include_once __DIR__ . '/../Includes/Header.php' ?>
<main>
    <div class="contenedor">
        <h2>Actualizar Categoria</h2>
        <form method="POST" action="/ProyectoPandora/Public/index.php?route=Device/ActualizarCategoria&id=<?= $categorias['id'] ?>">

            <input type="hidden" name="id" value="<?= $categorias['id'] ?>">

            <label>Nombre</label>
            <input type="text" name="nombre" value="<?= htmlspecialchars($categorias['name']) ?>" required>

            <button type="submit">Guardar</button>
        </form>
    </div>
</main>
<?php include_once __DIR__ . '/../Includes/Footer.php' ?>