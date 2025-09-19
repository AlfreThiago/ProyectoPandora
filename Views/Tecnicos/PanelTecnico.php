<?php include_once __DIR__ . '/../Includes/Sidebar.php'; ?>
<?php include_once __DIR__ . '/../Includes/Header.php'; ?>

<?php 
  // Detecta la ruta actual
  $rutaActual = isset($_GET['route']) ? $_GET['route'] : '';
?>
<main>
    <section class="content">
        <header class="header">
            <h1 class="header-title">Panel Tecnico</h1>
            <p class="header-subtitle">
                Bienvenido a la zona Tecnica
                <br>
                <span class="user-highlight">
                    <?php echo htmlspecialchars($_SESSION['user']['name']); ?>
                </span>
            </p>
            <div class="header-actions">
                <!-- Chat  -->
                <span class="icon-btn">
                    <i class='bx bx-chat'></i>
                </span>
                <!-- Perfil --> 
                <li class="profile-menu">
                    <a href="javascript:void(0)" id="btn-profile">
                        <img src="#" alt="Perfil" class="user-avatar">
                    </a>

                    <!-- Submenú -->
                    <div id="submenu-profile" class="submenu">
                        <div class="submenu-header">
                            <span class="user-avatar"></span>
                            <p class="user-name">¡Hola, <?php echo $_SESSION['user']['name']; ?>!</p>
                            <small class="user-email"><?php echo $_SESSION['user']['email']; ?></small>
                        </div>

                        <hr>

                        <ul>                            
                            <li>
                                <a href="/ProyectoPandora/Public/index.php?route=Default/Perfil">
                                    <i class='bx bx-user'></i>
                                    <span>Perfil</span>
                                </a>
                            </li>
                            <li>
                                <a href="/ProyectoPandora/Public/index.php?route=Default/Guia">
                                    <i class='bx bx-history'></i> 
                                    <span>Guia</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class='bx bx-bell-minus'></i>
                                    <span>Notificaciones</span>
                                </a>
                            </li>
                            <li>
                                <a href="/ProyectoPandora/Public/index.php?route=Dash/Ajustes">
                                    <i class='bxr  bx-cog'></i>
                                    <span>Ajustes</span>
                                </a>
                            </li>
                        </ul>

                        <hr>

                        <div class="submenu-footer">
                            <a href="/ProyectoPandora/Public/index.php?route=Auth/Logout" class="logout">
                            <i class='bx bx-log-out'></i> Cerrar sesión
                            </a>
                        </div>
                    </div>
                </li>           
            </div>
        </header> 

        <!-- Tabs -->
        <div class="tabs">
            <div class="tab <?php echo ($rutaActual === 'Ticket/Listar') ? 'active' : ''; ?>">
                <a href="/ProyectoPandora/Public/index.php?route=Tecnico/MisReparaciones">Mis Reparaciones</a>
            </div>
            <div class="tab <?php echo ($rutaActual === 'Device/ListarDevice') ? 'active' : ''; ?>">
                <a href="/ProyectoPandora/Public/index.php?route=Tecnico/MisRepuestos">Mis Repuestos</a>
            </div>
            <div class="tab <?php echo ($rutaActual === 'EstadoTicket/ListarEstados') ? 'active' : ''; ?>">
                <a href="/ProyectoPandora/Public/index.php?route=Tecnico/MisStats">Mis Stats</a>
            </div>
        </div>
    </section>
</main>
<script src="/ProyectoPandora/Public/js/modal.js"></script>
<?php include_once __DIR__ . '/../Includes/Footer.php' ?>