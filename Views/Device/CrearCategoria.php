    <main>
        <?php
        if (isset($_GET['error']) && $_GET['error'] === 'CamposRequeridos'): ?>
            <div style="color: red; margin-bottom: 10px;">
                Todos los campos son obligatorios.
            </div>
        <?php endif;
        if (isset($_GET['error']) && $_GET['error'] === 'ErrorAlAgregarCategoria'): ?>
            <div style="color: red; margin-bottom: 10px;">
                Error al agregar la categoría.
            </div>
        <?php endif;
        if (isset($_GET['success']) && $_GET['success'] === '1'): ?>
            <div style="color: green; margin-bottom: 10px;">
                Categoría agregada exitosamente.
            </div>
        <?php endif;
        ?>
        <div class="Contenedor">
            <section class="Conenedor-formulario-principal">
                <h2>Añadir Categoría</h2>
                <div class="Formulario-general">
                    <div class="Formulario-contenedor">
                        <form action="/ProyectoPandora/Public/index.php?route=Device/CrearCategoria" method="POST">
                            <p>
                                <label for="nombre">Nombre de la Categoría:</label>
                                <input type="text" name="nombre" autocomplete="off" required>
                            </p>
                            <p>
                                <button type="submit">Añadir</button>
                            </p>
                            <p>
                                <a href="/ProyectoPandora/Public/index.php?route=Dash/ListaCategoriaDevice" class="btn">Volver a la lista de categorías</a>
                            </p>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </main>