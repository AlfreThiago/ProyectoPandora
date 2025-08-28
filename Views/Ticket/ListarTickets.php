<?php include_once __DIR__ . '/../Includes/Header.php' ?>
<main>
    <div class="Tabla-Contenedor">
        <h2>Lista de Tickets</h2>
        <a href="CrearTicket.php" class="btn btn-success mb-3">Nuevo Ticket</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Dispositivo</th>
                    <th>Cliente</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                    <th>Técnico</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="ticketTable">
                <!-- El Controller va a inyectar las filas aquí -->
            </tbody>
        </table>
    </div>
</main>
<?php include_once __DIR__ . '/../Includes/Footer.php' ?>