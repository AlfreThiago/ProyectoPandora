<?php include_once __DIR__ . '/../Includes/Sidebar.php'; ?>
<body>
    <main>
        <section class="content">
            <header class="header">
                <h1 class="header-title">Panel Cliente</h1>
                <p class="header-subtitle">
                    Bienvenido a la zona Cliente
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
            <div class="tab active" onclick="showTab('dispositivos')">Dispositivos</div>
            <div class="tab" onclick="showTab('tickets')">Tickets</div>
        </div>
        
        <div id="dispositivos" class="tab-content">
            <div class="Contenedor">
                <section class="Conenedor-formulario-principal">
                    <h2>Agregar Dispositivo</h2>
                    <div class="Formulario-general">
                        <div class="Formulario-contenedor">
                            <form action="/ProyectoPandora/Public/index.php?route=Device/CrearDevice" method="POST" enctype="multipart/form-data">
                                <p>
                                    <label for="categoria_id">Categoría del Dispositivo:</label>
                                    <select id="categoria_id" name="categoria_id" required>
                                        <option value="1">Celulares</option>
                                        <option value="2">Computadora</option>
                                        <option value="3">Tablet</option>
                                        <option value="4">Electrodomésticos</option>
                                        <option value="5">Televisores</option>
                                    </select>
                                </p>
                                <p>
                                    <label for="marca">Marca:</label>
                                    <input type="text" id="marca" name="marca" required>
                                </p>
                                <p>
                                    <label for="modelo">Modelo:</label>
                                    <input type="text" id="modelo" name="modelo" required>
                                </p>
                                <p>
                                    <label for="descripcion_falla">Descripción de Falla:</label>
                                    <input type="text" id="descripcion_falla" name="descripcion_falla" required>
                                </p>
                                <p>
                                    <label for="img_dispositivo">Imagen del Dispositivo:</label>
                                    <input type="file" id="img_dispositivo" name="img_dispositivo" accept="image/*" required>
                                </p>
                                <p>
                                    <button type="submit">Agregar Dispositivo</button>
                                </p>
                            </form>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <!-- Tickets (cards) -->
        <div id="tickets" class="tab-content" style="display:none;">
                <div class="contenedor">
                    <h1>Crear nuevo Ticket</h1>
                    <form method="POST" action="/ProyectoPandora/Public/index.php?route=Ticket/Crear">

                        <label for="dispositivo">Seleccione un dispositivo:</label><br>
                        <select id="dispositivo" name="dispositivo_id" required onchange="mostrarDescripcion(this)">
                            <option value="">-- Seleccionar --</option>
                            <?php foreach ($data as $dispositivo): ?>
                                <option value="<?= $dispositivo['id'] ?>"
                                    data-descripcion="<?= htmlspecialchars($dispositivo['descripcion_falla']) ?>">
                                    <?= $dispositivo['marca'] . " " . $dispositivo['modelo'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select><br><br>

                        <label for="descripcion">Descripción de la falla:</label><br>
                        <textarea id="descripcion" name="descripcion" rows="5" required></textarea><br><br>

                        <button type="submit">Crear</button>
                        <a href="/ProyectoPandora/Public/index.php?route=Ticket/Listar">Cancelar</a>
                    </form>
                </div>

        </section>
    </main>
<script src="/ProyectoPandora/Public/js/Tablas.js"></script>
</body>
<?php include_once __DIR__ . '/../Includes/Footer.php' ?>