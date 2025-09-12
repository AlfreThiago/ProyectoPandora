<?php include_once __DIR__ . '/../Includes/Sidebar.php' ?>
<div class="Contenedor">
        <section class="Conenedor-formulario-principal">
            <h2>Actualizar Categoria</h2>
            <div class="Formulario-general">
                <div class="Formulario-contenedor">
                    <form method="POST" action="/ProyectoPandora/Public/index.php?route=Device/ActualizarCategoria&id=<?= $categorias['id'] ?>">
                        <p>
                            <input type="hidden" name="id" value="<?= $categorias['id'] ?>">
                        </p>
                        <p>
                            <label>Nombre</label>
                            <input type="text" name="nombre" value="<?= htmlspecialchars($categorias['name']) ?>" required>
                        </p>    
                        <p>
                            <button type="submit">Añadir</button>
                        </p>
                        <p>
                            <a href="/ProyectoPandora/Public/index.php?route=Device/ListarCategoria" class="btn-form-categoria">Volver a la lista de categorías</a>
                        </p>
                    </form>
                </div>
            </div>
        </section>
</div>
<?php include_once __DIR__ . '/../Includes/Footer.php' ?>