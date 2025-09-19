<?php include_once __DIR__ . '/../Includes/Sidebar.php'; ?>
<main>
    <div class="content">
        <div class="categoria-wrapper">
            <h3>Agregar Categoría de Inventario</h3>

            <?php if (isset($_GET['error'])): ?>
                <div style="color: red; font-weight: bold; margin-bottom: 15px;">
                    Ocurrió un error al agregar la categoría.
                </div>
            <?php endif; ?>

            <form action="/ProyectoPandora/Public/index.php?route=Inventario/CrearCategoria" method="POST">
                <label for="name">Nombre de la Categoría:</label>
                <input type="text" id="name" name="name" required>

                <button type="submit">Agregar Categoría</button>
            </form>

            <a href="<?= $_SESSION['prev_url'] ?? '/ProyectoPandora/Public/index.php?route=Default/Index' ?>" class="btn-volver">Volver</a>
        </div>
    </div>
</main>
<?php include_once __DIR__ . '/../Includes/Footer.php'; ?>
