<?php
include_once __DIR__ . '/../Includes/Sidebar.php'
?>
<main>
    <div class="Contenedor">
        <section class="Conenedor-formulario-principal">
            <h2>Actualizar Estado</h2>
            <div class="Formulario-general">
                <div class="Formulario-contenedor">
                    <form method="POST" action="/ProyectoPandora/Public/index.php?route=EstadoTicket/Actualizar">
                        <p>
                            <input type="hidden" name="id" value="<?= $estado['id'] ?>">
                        </p>
                        <p>
                            <label>Nombre del estado:</label>
                            <input type="text" name="name" value="<?= $estado['name'] ?>" required>
                        </p>
                        <p>
                            <button type="submit">Actualizar</button>
                        </p>
                    </form>
                </div>
            </div>
        </section>
    </div>
</main>
<?php
include_once __DIR__ . '/../Includes/Footer.php'
?>