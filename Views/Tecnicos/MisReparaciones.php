<?php include_once __DIR__ . '/../Includes/Sidebar.php'; ?>
<main>
        <section class="content">
        <header class="header">
            <h1 class="header-title">Tickets para Reparar</h1>
            <p class="header-subtitle">
                Aca estan todos los tickets que tienes asignados para reparar.
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

    <div class="Contenedor">
        <section class="section-mis-reparaciones">
            <br>
            <div class="cards-container">
                <?php if (!empty($tickets)): ?>
                    <?php foreach ($tickets as $ticket): ?>
                        <div class="device-card">
                            <div class="device-img">
                                <img src="/ProyectoPandora/Public/img/imgDispositivos/<?= htmlspecialchars($ticket['img_dispositivo']) ?>" alt="Imagen dispositivo">
                            </div>
                            <div class="device-info">
                                <h3><?= htmlspecialchars($ticket['marca']) ?> <?= htmlspecialchars($ticket['modelo']) ?></h3>
                                <p><strong>Cliente:</strong> <?= htmlspecialchars($ticket['cliente']) ?></p>
                                <p><strong>Descripción:</strong> <?= htmlspecialchars($ticket['descripcion_falla']) ?></p>
                                <p><strong>Estado:</strong> <?= htmlspecialchars($ticket['estado']) ?></p>
                                <p><strong>Fecha:</strong> <?= htmlspecialchars($ticket['fecha_creacion']) ?></p>
                                <a href="/ProyectoPandora/Public/index.php?route=Ticket/Ver&id=<?= $ticket['id'] ?>" class="btn btn-primary" style="margin-top:8px;">Ver detalle</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No tienes reparaciones asignadas.</p>
                <?php endif; ?>
            </div>
        </section>
    </div>
</main>
<style>
.cards-container {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: flex-start;
}
.device-card {
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    width: 260px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    transition: box-shadow 0.2s;
}
.device-card:hover {
    box-shadow: 0 4px 16px rgba(0,0,0,0.15);
}
.device-img img {
    width: 100%;
    height: 140px;
    object-fit: cover;
    border-bottom: 1px solid #eee;
}
.device-info {
    padding: 16px;
}
.device-info h3 {
    margin: 0 0 8px 0;
    font-size: 1.1em;
    color: #333;
}
.device-info p {
    margin: 4px 0;
    font-size: 0.95em;
    color: #555;
}
.btn.btn-primary {
    background: #007bff;
    color: #fff;
    padding: 6px 12px;
    border-radius: 4px;
    text-decoration: none;
    display: inline-block;
    font-size: 0.95em;
    transition: background 0.2s;
}
.btn.btn-primary:hover {
    background: #0056b3;
}
</style>
<?php include_once __DIR__ . '/../Includes/Footer.php' ?>