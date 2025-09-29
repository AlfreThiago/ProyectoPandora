<?php include_once __DIR__ . '/../Includes/Sidebar.php'; ?>

<main>
    <div class="content">

        <h1 class="logo">Inventario <span>Nueva Categoría</span></h1>

        <div class="categoriadevice-wrapper animated bounceInUp">
            <div class="form-container">
                <h3>Añadir Categoría</h3>

                <?php if (isset($_GET['error']) && $_GET['error'] === 'CamposRequeridos'): ?>
                    <div class="alert alert-warning">
                        Todos los campos son obligatorios.
                    </div>
                <?php endif; ?>

                <?php if (isset($_GET['error']) && $_GET['error'] === 'ErrorAlAgregarCategoria'): ?>
                    <div class="alert alert-warning">
                        Error al agregar la categoría.
                    </div>
                <?php endif; ?>

                <?php if (isset($_GET['success']) && $_GET['success'] === '1'): ?>
                    <div class="alert alert-success">
                        Categoría agregada exitosamente.
                    </div>
                <?php endif; ?>

                <form action="" method="POST">
                    <label for="nombre">Nombre de la Categoría:</label>
                    <input type="text" id="nombre" name="nombre" autocomplete="off" required>

                    <button type="submit">Añadir</button>
                </form>

                <a href="/ProyectoPandora/Public/index.php?route=Device/ListarCategoria" class="btn-volver">
                    Volver a la lista de categorías
                </a>
            </div>
        </div>

    </div>
</main>
