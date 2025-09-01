<?php include_once __DIR__ . '/../Includes/Sidebar.php'; ?>
<body>
    <main>
        <section class="content">
            <header class="header">
                <h1 class="header-title">Panel Supervisor</h1>
                <p class="header-subtitle">
                    Bienvenido a la zona del Supervisor
                    <br>
                    <span class="user-highlight">
                        <?php echo htmlspecialchars($_SESSION['user']['name']); ?>
                    </span>
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
                <div class="tab active" onclick="showTab('usuarios')">Usuarios</div>
                <div class="tab" onclick="showTab('tickets')">Tickets</div>
            </div>

            <!-- Usuarios (tabla) -->
            <div id="usuarios" class="tab-content">
                <div class="Tabla-Contenedor">
                    <h2>Lista de Usuarios</h2>
                    <div class="search-container">
                        <input type="text" id="userSearchInput" placeholder="Buscar usuario..." class="search-input">
                    </div>
                    <div class="filter-buttons">
                        <button onclick="filterTable('all')">Todos</button>
                        <button onclick="filterTable('Cliente')">Clientes</button>
                        <button onclick="filterTable('Tecnico')">Técnicos</button>
                        <button onclick="filterTable('Supervisor')">Supervisores</button>
                        <button onclick="filterTable('Administrador')">Admins</button>

                        <a href="/ProyectoPandora/Public/index.php?route=Register/RegisterAdmin" class="btn action-btn">Agregar User</a>
                    </div>
                    <table id="userTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Correo</th>
                                <th>Rol</th>
                                <th>Fecha de creación</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($users) && !empty($users)): ?>
                                <?php foreach ($users as $user): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($user['id']) ?></td>
                                        <td><?= htmlspecialchars($user['name']) ?></td>
                                        <td><?= htmlspecialchars($user['email']) ?></td>
                                        <?php $role = htmlspecialchars($user['role']); ?>
                                        <td><span class="role <?= $role ?>"><?= $role ?></span></td>
                                        <td><span class="created-at">🕒 <?= htmlspecialchars($user['created_at']) ?></span></td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="/ProyectoPandora/Public/index.php?route=Admin/ActualizarUser&id=<?= htmlspecialchars($user['id']) ?>&from=Admin/ListarUsers" class="btn edit-btn">Editar</a>
                                                <a href="/ProyectoPandora/Public/index.php?route=Admin/DeleteUser&id=<?= htmlspecialchars($user['id']) ?>" class="btn delete-btn">Eliminar</a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="6">No hay usuarios registrados.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tickets (cards) -->
            <div id="tickets" class="tab-content" style="display:none;">
                <div class="filter-buttons">
                    <a href="/ProyectoPandora/Public/index.php?route=Ticket/Agregar" class="btn action-btn">Añadir Ticket</a>
                </div>

                <div class="cards">
                    <?php if (!empty($tickets)): ?>
                        <?php foreach ($tickets as $ticket): ?>
                            <div class="card">
                                <h3>#<?= htmlspecialchars($ticket['id']) ?> - <?= htmlspecialchars($ticket['titulo']) ?></h3>
                                <p><strong>Cliente:</strong> <?= htmlspecialchars($ticket['cliente']) ?></p>
                                <p><strong>Prioridad:</strong> <?= htmlspecialchars($ticket['prioridad']) ?></p>
                                
                                <!-- Estado -->
                                <?php 
                                    $estadoClass = strtolower($ticket['estado']); 
                                    // ejemplo: "Abierto" => "abierto", "Cerrado" => "cerrado"
                                ?>
                                <span class="status <?= $estadoClass ?>">
                                    <?= htmlspecialchars($ticket['estado']) ?>
                                </span>

                                <!-- Acciones -->
                                <div class="action-buttons">
                                    <a href="/ProyectoPandora/Public/index.php?route=Ticket/Ver&id=<?= htmlspecialchars($ticket['id']) ?>" class="btn view-btn">Ver</a>
                                    <a href="/ProyectoPandora/Public/index.php?route=Ticket/Editar&id=<?= htmlspecialchars($ticket['id']) ?>" class="btn edit-btn">Editar</a>
                                    <a href="/ProyectoPandora/Public/index.php?route=Ticket/Eliminar&id=<?= htmlspecialchars($ticket['id']) ?>" class="btn delete-btn">Eliminar</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No hay tickets registrados.</p>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    </main>
<script src="/ProyectoPandora/Public/js/Tablas.js"></script>
</body>
<?php include_once __DIR__ . '/../Includes/Footer.php' ?>