<?php include_once __DIR__ . '/../Includes/Sidebar.php'; ?>
<body>
    <main>
    <section class="content">
        <header class="header">
                <h1 class="header-title">Panel Tecnico</h1>
                <p class="header-subtitle">
                    Bienvenido a la zona tecnica
                    <br>
                    <!-- <span class="user-highlight">
                        <?php echo htmlspecialchars($_SESSION['user']['name']); ?>
                    </span> -->
                </p>
                <div class="header-actions">
                    <!-- Notificaciones -->
                    <span class="icon-btn">
                        <i class='bx bx-bell'></i>
                    </span>

                    <!-- Chat -->
                    <span class="icon-btn">
                        <i class='bx bx-chat'></i>
                    </span>

                    <!-- Avatar -->
                    <span class="user-avatar"></span>
                </div>
        </header>

        <!-- Tabs -->
        <div class="tabs">
            <div class="tab active" onclick="showTab('dispositivos')">Dispositivos</div>
            <div class="tab" onclick="showTab('tickets')">Tickets</div>
            <div class="tab" onclick="showTab('estadotickets')">Estados Tickets</div>
        </div>

        <!-- Tickets (cards) -->
        <div id="tickets" class="tab-content" style="display:none;">
            <div class="filter-buttons">
                <!-- Van a formularios -->
                <a href="/ProyectoPandora/Public/index.php?route=Ticket/Agregar" class="btn action-btn">Añadir Ticket</a>
                <a href="/ProyectoPandora/Public/index.php?route=Ticket/verTicket" class="btn action-btn">Ver Ticket</a>
            </div>
            
            <div class="tickets-container">
                <h2>Lista de Tickets</h2>
                <div class="cards" id="ticketCards">
                    <!-- Aquí el controlador inyectará las cards -->
                </div>
            </div>
            <?php if (!empty($tickets) && is_array($tickets)): ?>
                <?php foreach ($tickets as $ticket): ?>
                    <div class="card">
                        <h3>#<?= $ticket['id'] ?> - <?= $ticket['descripcion'] ?></h3>
                        <p><strong>Cliente:</strong> <?= $ticket['cliente'] ?></p>
                        <p><strong>Prioridad:</strong> <?= $ticket['prioridad'] ?></p>
                        <span class="status <?= strtolower($ticket['estado']) ?>">
                            <?= ucfirst($ticket['estado']) ?>
                        </span>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No hay tickets disponibles.</p>
            <?php endif; ?>


        </div>

        <!-- Dispositivos (tabla) -->
        <div id="dispositivos" class="tab-content">
            <div class="Tabla-Contenedor">
                <h2>Lista de Dispositivos</h2>
                    
                <!-- Buscador -->
                <div class="search-container">
                    <input type="text" id="deviceSearchInput" placeholder="Buscar dispositivo..." class="search-input">
                </div>

                <!-- Botones -->
                <div class="filter-buttons">

                    <!-- Van a formularios -->
                    <a href="/ProyectoPandora/Public/index.php?route=Device/CrearDevice" class="btn action-btn">Añadir Device</a>
                    <a href="/ProyectoPandora/Public/index.php?route=Device/ActualizarDevice" class="btn action-btn">Actualizar Device</a>
                </div>

                <!-- Tabla de dispositivos -->
                <table id="dispositivosTable" class="device-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Usuario</th>
                            <th>Categoria</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Descripcion de Falla</th>
                            <th>Imagen</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($dispositivos)): ?>
                        <?php foreach ($dispositivos as $dispositivo): ?>
                            <tr>
                                <td><?= htmlspecialchars($dispositivo['id']) ?></td>
                                <td><?= htmlspecialchars($dispositivo['users']) ?></td>
                                <td><?= htmlspecialchars($dispositivo['categoria']) ?></td>
                                <td><?= htmlspecialchars($dispositivo['marca']) ?></td>
                                <td><?= htmlspecialchars($dispositivo['modelo']) ?></td>
                                <td><?= htmlspecialchars($dispositivo['descripcion_falla']) ?></td>
                                <td>
                                <img src="/ProyectoPandora/Public/img/imgDispositivos/<?= htmlspecialchars($dispositivo['img_dispositivo']) ?>" width="80">
                                </td>
                                <td>
                                <a href="/ProyectoPandora/Public/index.php?route=Device/ActualizarDevice&id=<?= $dispositivo['id'] ?>" class="btn edit-btn">Actualizar</a>
                                <a href="/ProyectoPandora/Public/index.php?route=Device/DeleteDevice&id=<?= $dispositivo['id'] ?>" class="btn delete-btn">Eliminar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <tr><td colspan="8">No hay dispositivos registrados.</td></tr>
                        <?php endif; ?> 
                    </tbody>
                </table>
            </div>
        </div>

        <div id="estadotickets" class="tab-content" style="display:none;">
            <div class="filter-buttons">
                <!-- Van a formularios -->
                <a class="btn action-btn" href="/ProyectoPandora/Public/index.php?route=EstadoTicket/Crear">Agregar Nuevo Estado</a>
            </div>
            <div class="Tabla-Contenedor">
                <h2>Lista de Estados</h2>
                <div class="serch-container">
                    <div>
                        <table id="userTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre del Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($estados as $estado): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($estado['id']); ?></td>
                                        <td><?php echo htmlspecialchars($estado['name']); ?></td>
                                        <td>
                                        <a href="/ProyectoPandora/Public/index.php?route=EstadoTicket/Editar&id=<?php echo $estado['id']; ?>" class="btn edit-btn">Actualizar</a>
                                        <a href="/ProyectoPandora/Public/index.php?route=EstadoTicket/Eliminar&id=<?php echo $estado['id']; ?>" class="btn delete-btn">Eliminar</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                                <?php if (empty($estados)): ?>
                                    <tr>
                                        <td colspan="3">No hay estados disponibles.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>

                        </table>
                        </div>
                    </div>

                </div>
        </div>
    </section>
    </main>
<script src="/ProyectoPandora/Public/js/Tablas.js"></script>
</body>
<?php include_once __DIR__ . '/../Includes/Footer.php' ?>