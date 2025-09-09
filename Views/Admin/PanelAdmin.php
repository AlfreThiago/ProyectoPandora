<?php include_once __DIR__ . '/../Includes/Sidebar.php'; ?>
<?php 
  // Detecta la ruta actual
  $rutaActual = isset($_GET['route']) ? $_GET['route'] : '';
?>
<main>
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
            <div class="tab <?php echo ($rutaActual === 'Admin/ListarUsers') ? 'active' : ''; ?>">
                <a href="/ProyectoPandora/Public/index.php?route=Admin/ListarUsers">Usuarios</a>
            </div>
            <div class="tab <?php echo ($rutaActual === 'Ticket/Listar') ? 'active' : ''; ?>">
                <a href="/ProyectoPandora/Public/index.php?route=Ticket/Listar">Tickets</a>
            </div>
            <div class="tab <?php echo ($rutaActual === 'Device/ListarDevice') ? 'active' : ''; ?>">
                <a href="/ProyectoPandora/Public/index.php?route=Device/ListarDevice">Dispositivos</a>
            </div>
            <div class="tab <?php echo ($rutaActual === 'EstadoTicket/ListarEstados') ? 'active' : ''; ?>">
                <a href="/ProyectoPandora/Public/index.php?route=EstadoTicket/ListarEstados">Estados tickets</a>
            </div>
        </div>
        <tbody>
            <div class="grid">
                <div class="small-box">
                    <div class="inner">
                        <h3>150</h3>
                        <p>New Orders</p>
                    </div>
                <div class="icon">👜</div>
                    <a href="#" class="small-box-footer">
                        More info →
                    </a>
                </div>

                <div class="small-box" style="background:var(--color-texto-primario);">
                    <div class="inner">
                        <h3>53</h3>
                        <p>Users Registered</p>
                    </div>
                    <div class="icon">👤</div>
                    <a href="#" class="small-box-footer">
                        More info →
                    </a>
                </div>
            </div>

        </tbody>
    </section>
</main>