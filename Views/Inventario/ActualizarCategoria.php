<?php include_once __DIR__ . '/../Includes/Sidebar.php'; ?>
<main>
    <div class="Contenedor">
                <section class="Conenedor-formulario-principal">
                    <h2>Actualizar Categoría</h2>
                    <div class="Formulario-general">
                            <div class="Formulario-contenedor">
                                <form method="POST" action="/ProyectoPandora/Public/index.php?route=Inventario/EditarCategoria&id=<?= $categoria['id'] ?>">
                                <p>
                                    <input type="hidden" name="id" value="<?= $categoria['id'] ?>">
                                </p>    
                                <p>
                                    <label for="name">Nombre de la categoría:</label>
                                    <input type="text" id="name" name="name" value="<?= htmlspecialchars($categoria['name'] ?? '') ?>" required>
                                </p>
                                <p>
                                    <button type="submit">Guardar cambios</button>
                                </p>
                                <p>
                                    <a href="/ProyectoPandora/Public/index.php?route=Inventario/ListarCategorias" class="btn-form-categoria">Volver</a>
                                </p>
                                </form>
                            </div>
                    </div>
                </section>
    </div>
</main>
<?php include_once __DIR__ . '/../Includes/Footer.php'; ?>