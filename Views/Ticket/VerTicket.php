<?php include_once __DIR__ . '/../Includes/Sidebar.php' ?>
<?php include_once __DIR__ . '/../Admin/PanelAdmin.php' ?>
<main>
    <div>
        <h2 id="tituloDetalle">Detalle del Ticket</h2>
        <ul class="list-group" id="detalleTicket">
            <!-- El Controller inyecta los <li> acá -->
        </ul>
        <a href="ListarTicket.php" class="btn btn-secondary mt-3">Volver</a>
    </div>
</main>
<?php include_once __DIR__ . '/../Includes/Footer.php' ?>