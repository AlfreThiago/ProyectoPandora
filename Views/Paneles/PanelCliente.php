<?php include_once __DIR__ . '/../Includes/Sidebar.php'; ?>
<?php include_once __DIR__ . '/../Includes/Header.php'; ?>

<?php 
  // Detecta la ruta actual
  $rutaActual = isset($_GET['route']) ? $_GET['route'] : '';
?>
<main>
    <section class="content">
        <header class="header">
            <h1 class="header-title">Panel Cliente</h1>
            <p class="header-subtitle">
                Bienvenido a la zona Tecnica
                <br>
                <span class="user-highlight">
                    <?php echo htmlspecialchars($_SESSION['user']['name']); ?>
                </span>
            </p>
            <div class="header-actions">
                <!-- Notificaciones  -->
                <span class="icon-btn">
                    <i class='bx bx-bell'></i>
                </span>

                <!-- Chat  -->
                <span class="icon-btn">
                    <i class='bx bx-chat'></i>
                </span>

                <!-- Avatar -->
                <span class="user-avatar"></span>
            </div>
        </header> 

        <!-- Tabs -->
        <div class="tabs">
            <div class="tab <?php echo ($rutaActual === 'Ticket/Listar') ? 'active' : ''; ?>">
                <a href="/ProyectoPandora/Public/index.php?route=Ticket/Crear">Tickets</a>
            </div>
            <div class="tab <?php echo ($rutaActual === 'Device/ListarDevice') ? 'active' : ''; ?>">
                <a href="/ProyectoPandora/Public/index.php?route=Device/CrearDevice">Dispositivos</a>
            </div>

        </div>
    </section>
        
</main>
<?php include_once __DIR__ . '/../Includes/Footer.php' ?>