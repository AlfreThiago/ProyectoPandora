<?php include_once __DIR__ . '/../Includes/Sidebar.php'; ?>

<body>
    <main>
        <!-- Main content -->
        <section class="content">
            <header class="header">
                <h1 class="header-title">Panel Administrador</h1>
                <p class="header-subtitle">
                    Bienvenido a la zona admin
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
                <div class="tab" onclick="showTab('dispositivos')">Dispositivos</div>
                <div class="tab" onclick="showTab('estadotickets')">Estados Tickets</div>
            </div>

            <!-- Usuarios (tabla) -->
            <div id="usuarios" class="tab-content">
                <div class="Tabla-Contenedor">
                    <h2>Lista de Usuarios</h2>
                    <div class="search-container">
                        <input type="text" id="userSearchInput" placeholder="Buscar usuario..." class="search-input">
                    </div>
                    <div class="filter-buttons">
                        <a href="/ProyectoPandora/Public/index.php?route=Admin/ListarUsers" class="btn action-btn">Todos los users</a>
                        <a href="/ProyectoPandora/Public/index.php?route=Admin/ListarClientes" class="btn action-btn">Clientes</a>
                        <a href="/ProyectoPandora/Public/index.php?route=Admin/ListarTecnicos" class="btn action-btn">Técnicos</a>
                        <a href="/ProyectoPandora/Public/index.php?route=Admin/ListarSupervisores" class="btn action-btn">Supervisor</a>
                        <a href="/ProyectoPandora/Public/index.php?route=Admin/ListarAdmins" class="btn action-btn">Admins</a>
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
                                <tr>
                                    <td colspan="6">No hay usuarios registrados.</td>
                                </tr>
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

            <!-- Dispositivos (tabla) -->
            <div id="dispositivos" class="tab-content" style="display:none;">
                <div class="Tabla-Contenedor">
                    <h2>Lista de Dispositivos</h2>

                    <!-- Buscador -->
                    <div class="search-container">
                        <input type="text" id="deviceSearchInput" placeholder="Buscar dispositivo..." class="search-input">
                    </div>

                    <!-- Botones -->
                    <div class="filter-buttons">
                        <!-- Cambian entre tablas -->
                        <a href="/ProyectoPandora/Public/index.php?route=Device/ListarDevice" class="btn action-btn">Lista de Dispositivos</a>
                        <a href="/ProyectoPandora/Public/index.php?route=Device/ListarCategoria" class="btn action-btn">Lista de Categorías</a>

                        <!-- Van a formularios -->
                        <a href="/ProyectoPandora/Public/index.php?route=Device/CrearCategoria" class="btn action-btn">Crear Categoria</a>
                        <a href="/ProyectoPandora/Public/index.php?route=Device/CrearDevice" class="btn action-btn">Añadir Device</a>
                        <a href="/ProyectoPandora/Public/index.php?route=Device/ActualizarDevice" class="btn action-btn">Actualizar Device</a>
                        <a href="/ProyectoPandora/Public/index.php?route=Device/ActualizarCategoria" class="btn action-btn">Actualizar Categoria</a>
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
                                <tr>
                                    <td colspan="8">No hay dispositivos registrados.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>

                    <!-- Tabla de categorías (oculta por defecto) -->
                    <table id="categoriasTable" class="device-table" style="display:none;">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre Categoría</th>
                                <th>Descripción</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($categorias)): ?>
                                <?php foreach ($categorias as $categoria): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($categoria['id']) ?></td>
                                        <td><?= htmlspecialchars($categoria['nombre']) ?></td>
                                        <td><?= htmlspecialchars($categoria['descripcion']) ?></td>
                                        <td>
                                            <a href="/ProyectoPandora/Public/index.php?route=Device/ActualizarCategoria&id=<?= $categoria['id'] ?>" class="btn edit-btn">Actualizar</a>
                                            <a href="/ProyectoPandora/Public/index.php?route=Device/DeleteCategoria&id=<?= $categoria['id'] ?>" class="btn delete-btn">Eliminar</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4">No hay categorías registradas.</td>
                                </tr>
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