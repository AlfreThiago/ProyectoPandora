<?php include_once __DIR__ . '/../Includes/Sidebar.php'; ?>
<main>
    <div class="content">

        <div class="contact-wrapper animated bounceInUp">
            <div class="contact-form">
                <h3>Actualizar Categoría</h3>

                <form method="POST" action="/ProyectoPandora/Public/index.php?route=Inventario/EditarCategoria&id=<?= htmlspecialchars($categoria['id']) ?>">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($categoria['id']) ?>">

                    <p>
                        <label for="name">Nombre de la categoría:</label>
                        <input type="text" id="name" name="name" value="<?= htmlspecialchars($categoria['name'] ?? '') ?>" required>
                    </p>

                    <p class="block">
                        <button type="submit">Guardar cambios</button>
                    </p>
                </form>

                <a href="/ProyectoPandora/Public/index.php?route=Inventario/ListarCategorias" class="btn-volver">Volver</a>
            </div>
        </div>

    </div>
</main>

<?php include_once __DIR__ . '/../Includes/Footer.php'; ?>
