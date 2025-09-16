<?php include_once __DIR__ . '/../Includes/Sidebar.php'; ?>

<main>
    <div class="Contenedor">
        <section class="Conenedor-formulario-principal">
            <h2>Agregar Categoría de Inventario</h2>
            <div class="Formulario-general">
                <div class="Formulario-contenedor">
                    <?php if (isset($_GET['error'])): ?>
                        <div style="color: red; font-weight: bold; margin-bottom: 15px;">
                            Ocurrió un error al agregar la categoría.
                        </div>
                    <?php endif; ?>
                    <form action="/ProyectoPandora/Public/index.php?route=Inventario/CrearCategoria" method="POST">
                        <p>
                            <label for="name">Nombre de la Categoría:</label>
                            <input type="text" id="name" name="name" required>
                        </p>
                        <p>
                        <button type="submit">Agregar Categoría</button>
                    </form>
                </div>
            </div>
        </section>
    </div>
</main>
<?php include_once __DIR__ . '/../Includes/Footer.php' ?>