<?php include_once __DIR__ . '/../Includes/Sidebar.php' ?>
<main>
    <div class="Tabla-Contenedor">
        <h2>Lista de Tickets</h2>
        <div class="botones">
            <div class="dropdown">
                <label for="menu-toggle" class="dropdown-label" >
                    Opciones<i class='bxr  bx-caret-down'  ></i> </label>
                <input type="checkbox" id="menu-toggle" />
            
                <div class="dropdown-menu">
                    <a class="btn-table" href="#">Todos</a> <!-- En proceso /Ale -->
                </div>
                
            </div>
            <div class="btn-table-acciones">
                <a class="btn-acciones-user" href="/ProyectoPandora/Public/index.php?route=Ticket/Crear">Crear TIcket</a>
            </div>
        </div>
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