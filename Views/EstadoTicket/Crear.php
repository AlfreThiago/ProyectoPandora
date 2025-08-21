<?php include_once __DIR__ . '/../Includes/Header.php'; ?>
<main>
    <div class="Contenedor">
        <section class="Conenedor-formulario-principal">
            <h2>Agregar Estado de Ticket</h2>
            <div class="Formulario-general">
                <div class="Formulario-contenedor">
                    <form action="/ProyectoPandora/Public/index.php?route=EstadoTicket/Crear" method="POST">
                        <p>
                            <label for="name">Nombre del Estado:</label>
                            <input type="text" id="name" name="name" required>
                        </p>
                        <p>
                            <button type="submit">Agregar Estado</button>
                        </p>
                    </form>
                </div>
            </div>
        </section>
    </div>
</main>
<?php include_once __DIR__ . '/../Includes/Footer.php' ?>