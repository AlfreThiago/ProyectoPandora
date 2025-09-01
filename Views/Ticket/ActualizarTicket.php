<?php include_once __DIR__ . '/../Includes/Sidebar.php' ?>
<main>
    <div class="contenedor">
        <h2 id="tituloEdicion">Editar Ticket</h2>
        <form id="formActualizar" method="POST" action="/ProyectoPandora/Public/index.php?route=Ticket/Actualizar">
            <input type="hidden" name="id" id="ticketId">

            <div class="mb-3">
                <label class="form-label">Descripción de la falla</label>
                <textarea name="descripcion_falla" id="descripcionFalla" class="form-control" rows="3" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            <a href="ListarTicket.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</main>
<?php include_once __DIR__ . '/../Includes/Footer.php' ?>