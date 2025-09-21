<?php include_once __DIR__ . '/../Includes/Sidebar.php'; ?>
<main>
    <div class="content">

        <div class="contact-wrapper animated bounceInUp">
            <div class="contact-form">
                <h3>Actualizar Categoría</h3>

                <form method="POST" action="/ProyectoPandora/Public/index.php?route=Device/ActualizarCategoria&id=<?= htmlspecialchars($categoria['id'] ?? '') ?>">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($categoria['id'] ?? '') ?>">

                    <p>
                        <label for="nombre">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($categoria['name'] ?? '') ?>" required>
                    </p>    

                    <p class="block">
                        <button type="submit">Actualizar</button>
                    </p>
                </form>

                <a href="/ProyectoPandora/Public/index.php?route=Device/ListarCategoria" class="btn-volver">Volver a la lista de categorías</a>
            </div>
        </div>

    </div>
</main>

<?php include_once __DIR__ . '/../Includes/Footer.php'; ?>
