<?php include_once __DIR__ . '/../Includes/Sidebar.php'; ?>

<main>
    <div class="Contenedor">
        <section class="Conenedor-formulario-principal">
            <h2>Agregar Item al Inventario</h2>
            <?php if (isset($errorMsg)): ?>
                <div class="alert alert-warning"><?= htmlspecialchars($errorMsg) ?></div>
            <?php endif; ?>

            <?php if (!isset($errorMsg)): ?>
                <div class="Formulario-general">
                    <div class="Formulario-contenedor">
                        <form action="/ProyectoPandora/Public/index.php?route=Inventario/CrearItem" method="POST" enctype="multipart/form-data">
                            <p>
                                <label for="categoria_id">Categoría:</label>
                                <select id="categoria_id" name="categoria_id" required>
                                    <option value="">-- Seleccionar --</option>
                                    <?php foreach ($categorias as $cat): ?>
                                        <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </p>
                            <p>
                                <label for="name_item">Nombre del Item:</label>
                                <input type="text" id="name_item" name="name_item" required>
                            </p>
                            <p>
                                <label for="valor_unitario">Valor Unitario:</label>
                                <input type="number" step="0.01" id="valor_unitario" name="valor_unitario" required>
                            </p>
                            <p>
                                <label for="descripcion">Descripción:</label>
                                <textarea id="descripcion" name="descripcion" rows="3"></textarea>
                            </p>
                            <p>
                                <label for="foto_item">Imagen:</label>
                                <input type="file" id="foto_item" name="foto_item" accept="image/*">
                            </p>
                            <p>
                                <label for="stock_actual">Stock Actual:</label>
                                <input type="number" id="stock_actual" name="stock_actual" required>
                            </p>
                            <p>
                                <label for="stock_minimo">Stock Mínimo:</label>
                                <input type="number" id="stock_minimo" name="stock_minimo" required>
                            </p>
                            <button type="submit">Agregar Item</button>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
            <a href="<?= $_SESSION['prev_url'] ?? '/ProyectoPandora/Public/index.php?route=Default/Index' ?>" class="btn btn-secondary">Volver</a>
        </section>
    </div>
</main>
<?php include_once __DIR__ . '/../Includes/Footer.php' ?>