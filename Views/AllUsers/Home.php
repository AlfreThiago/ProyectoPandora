<?php 
include_once __DIR__ . '/../Includes/Sidebar.php'; 
$role = strtolower($authUser['role'] ?? 'invitado');
?>

<main>
    <?php include_once __DIR__ . '/../Includes/Header.php'; ?>

    <div class="home-container">
        <!-- HERO -->
        <section class="home-hero">
            <div class="hero-left">
                <h2><i class='bx bx-grid-alt'></i> Portal de gestión — todo en un solo lugar</h2>
                <p>Accedé rápido a tus herramientas, tickets y dispositivos. Cada rol tiene su propio espacio para facilitar la gestión y comunicación.</p>
                <div class="home-cta">
                    <?php if ($role === 'invitado'): ?>
                        <a class="btn-a" href="index.php?route=Auth/Login"><i class='bx bx-log-in'></i> Iniciar sesión</a>
                        <a class="btn-b" href="index.php?route=Register/Register"><i class='bx bx-user-plus'></i> Registrarse</a>
                    <?php elseif ($role === 'cliente'): ?>
                        <a class="btn-a" href="index.php?route=Cliente/MisTicket"><i class='bx bx-support'></i> Ver mis tickets</a>
                        <a class="btn-b" href="index.php?route=Cliente/MisDevice"><i class='bx bx-laptop'></i> Mis dispositivos</a>
                        <a class="btn-c" href="index.php?route=Ticket/Crear"><i class='bx bx-plus-circle'></i> Crear ticket</a>
                    <?php elseif ($role === 'tecnico'): ?>
                        <a class="btn-a" href="index.php?route=Tecnico/MisReparaciones"><i class='bx bx-wrench'></i> Mis reparaciones</a>
                        <a class="btn-b" href="index.php?route=Tecnico/MisStats"><i class='bx bx-line-chart'></i> Mis estadísticas</a>
                    <?php elseif ($role === 'supervisor'): ?>
                        <a class="btn-a" href="index.php?route=Supervisor/Asignar"><i class='bx bx-user-voice'></i> Asignar técnico</a>
                        <a class="btn-b" href="index.php?route=Supervisor/Presupuestos"><i class='bx bx-wallet'></i> Ver presupuestos</a>
                    <?php elseif ($role === 'administrador'): ?>
                        <a class="btn-a" href="index.php?route=Admin/ListarUsers"><i class='bx bx-user'></i> Gestión de usuarios</a>
                        <a class="btn-b" href="index.php?route=Historial/ListarHistorial"><i class='bx bx-history'></i> Historial del sistema</a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="hero-right">
                <div class="hero-stats">
                    <div class="stat">
                        <i class='bx bx-time-five'></i>
                        <span class="num" id="activeTickets">3</span>
                        <span class="label">Tickets activos</span>
                    </div>
                    <div class="stat">
                        <i class='bx bx-star'></i>
                        <span class="num">4.8</span>
                        <span class="label">Promedio general</span>
                    </div>
                    <div class="stat">
                        <i class='bx bx-refresh'></i>
                        <span class="num">24h</span>
                        <span class="label">Última actualización</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- CONTENIDO PRINCIPAL -->
        <div class="home-wrap">
            <div class="home-grid">

                <?php if ($role === 'invitado'): ?>
                    <!-- INVITADO -->
                    <article class="home-card">
                        <h3><i class='bx bx-compass'></i> Explorá el portal</h3>
                        <p>Podés conocer nuestras funciones y servicios. Iniciá sesión para acceder a tu panel personalizado.</p>
                        <a class="home-link" href="index.php?route=Auth/Login"><i class='bx bx-log-in-circle'></i> Ir al login</a>
                    </article>

                    <article class="home-card">
                        <h3><i class='bx bx-help-circle'></i> Soporte técnico</h3>
                        <p>Recibí asistencia profesional con seguimiento en línea y notificaciones en tiempo real.</p>
                        <a class="home-link" href="index.php?route=Auth/Login"><i class='bx bx-chat'></i> Solicitar ayuda</a>
                    </article>

                <?php elseif ($role === 'cliente'): ?>
                    <!-- CLIENTE -->
                    <article class="home-card">
                        <h3><i class='bx bx-laptop'></i> Mis dispositivos</h3>
                        <p>Visualizá los equipos registrados y su estado actual.</p>
                        <a class="home-link" href="index.php?route=Cliente/MisDevice"><i class='bx bx-folder'></i> Ver dispositivos</a>
                    </article>

                    <article class="home-card">
                        <h3><i class='bx bx-support'></i> Mis tickets</h3>
                        <p>Consultá el estado de tus reparaciones y mantené contacto directo con el técnico asignado.</p>
                        <a class="home-link" href="index.php?route=Cliente/MisTicket"><i class='bx bx-list-ul'></i> Ver tickets</a>
                    </article>

                    <article class="home-card">
                        <h3><i class='bx bx-like'></i> Calificar servicio</h3>
                        <p>Evaluá el servicio recibido y ayudanos a mejorar.</p>
                        <a class="home-link" href="index.php?route="><i class='bx bx-star'></i> Calificar</a>
                    </article>

                <?php elseif ($role === 'tecnico'): ?>
                    <!-- TÉCNICO -->
                    <article class="home-card">
                        <h3><i class='bx bx-wrench'></i> Mis reparaciones</h3>
                        <p>Accedé a los tickets asignados y actualizá su progreso.</p>
                        <a class="home-link" href="index.php?route=Tecnico/MisReparaciones"><i class='bx bx-cog'></i> Ver reparaciones</a>
                    </article>

                    <article class="home-card">
                        <h3><i class='bx bx-package'></i> Repuestos asignados</h3>
                        <p>Controlá el inventario de piezas utilizadas en tus reparaciones.</p>
                        <a class="home-link" href="index.php?route=Tecnico/MisRepuestos"><i class='bx bx-box'></i> Ver repuestos</a>
                    </article>

                    <article class="home-card">
                        <h3><i class='bx bx-line-chart'></i> Mis estadísticas</h3>
                        <p>Consultá tu desempeño y métricas personales.</p>
                        <a class="home-link" href="index.php?route=Tecnico/MisStats"><i class='bx bx-bar-chart'></i> Ver estadísticas</a>
                    </article>

                <?php elseif ($role === 'supervisor'): ?>
                    <!-- SUPERVISOR -->
                    <article class="home-card">
                        <h3><i class='bx bx-wallet'></i> Presupuestos</h3>
                        <p>Gestioná los presupuestos generados por los técnicos antes de la aprobación del cliente.</p>
                        <a class="home-link" href="index.php?route=Supervisor/Presupuestos"><i class='bx bx-search-alt'></i> Ver presupuestos</a>
                    </article>

                    <article class="home-card">
                        <h3><i class='bx bx-cabinet'></i> Gestión de inventario</h3>
                        <p>Supervisá el stock disponible y los repuestos asignados.</p>
                        <a class="home-link" href="index.php?route=Supervisor/GestionInventario"><i class='bx bx-box'></i> Ir al inventario</a>
                    </article>

                    <article class="home-card">
                        <h3><i class='bx bx-user-voice'></i> Asignar técnicos</h3>
                        <p>Asigná tareas y tickets a los técnicos disponibles según prioridad.</p>
                        <a class="home-link" href="index.php?route=Supervisor/Asignar"><i class='bx bx-check'></i> Asignar</a>
                    </article>

                <?php elseif ($role === 'administrador'): ?>
                    <!-- ADMINISTRADOR -->
                    <article class="home-card">
                        <h3><i class='bx bx-user'></i> Gestión de usuarios</h3>
                        <p>Alta, baja y modificación de cuentas activas dentro del sistema.</p>
                        <a class="home-link" href="index.php?route=Admin/ListarUsers"><i class='bx bx-group'></i> Ver usuarios</a>
                    </article>

                    <article class="home-card">
                        <h3><i class='bx bx-history'></i> Historial del sistema</h3>
                        <p>Revisá los eventos registrados para auditorías internas.</p>
                        <a class="home-link" href="index.php?route=Historial/ListarHistorial"><i class='bx bx-time'></i> Ver historial</a>
                    </article>

                    <article class="home-card">
                        <h3><i class='bx bx-slider-alt'></i> Categorías y estados</h3>
                        <p>Configurá categorías de dispositivos, inventario y estados de ticket.</p>
                        <a class="home-link" href="index.php?route=EstadoTicket/ListarEstados"><i class='bx bx-cog'></i> Ir a configuración</a>
                    </article>
                <?php endif; ?>

                <!-- NOVEDADES -->
                <section class="home-news card-wide">
                    <h3><i class='bx bx-news'></i> Novedades</h3>
                    <ul>
                        <li><strong>Nuevo:</strong> Seguimiento de repuestos en tiempo real disponible.</li>
                        <li><strong>Info:</strong> Mantenimiento programado — 12 Oct (00:00 - 02:00)</li>
                        <li><strong>Tip:</strong> Recordá calificar al técnico tras finalizar tu reparación.</li>
                    </ul>
                </section>

                <!-- ACCESOS RÁPIDOS -->
                <aside class="quick-actions card-wide">
                    <h3><i class='bx bx-bolt'></i> Accesos rápidos</h3>
                    <div class="qa-grid">
                        <?php if ($role === 'invitado'): ?>
                            <a class="qa" href="index.php?route=Auth/Login"><i class='bx bx-plus-circle'></i> Crear ticket</a>
                            <a class="qa" href="index.php?route=Auth/Login"><i class='bx bx-laptop'></i> Mis dispositivos</a>
                            <a class="qa" href="index.php?route=Auth/Login"><i class='bx bx-bar-chart'></i> Reportes</a>
                            <a class="qa" href="index.php?route=Auth/Login"><i class='bx bx-receipt'></i> Facturación</a>
                        <?php elseif ($role === 'cliente'): ?>
                            <a class="qa" href="index.php?route=Cliente/CrearTicket"><i class='bx bx-plus-circle'></i> Crear ticket</a>
                            <a class="qa" href="index.php?route=Cliente/MisDevice"><i class='bx bx-laptop'></i> Mis dispositivos</a>
                            <a class="qa" href="index.php?route=Cliente/MisTicket"><i class='bx bx-list-ul'></i> Mis tickets</a>
                            <a class="qa" href="#"><i class='bx bx-receipt'></i> Facturación</a>
                        <?php elseif ($role === 'tecnico'): ?>
                            <a class="qa" href="index.php?route=Tecnico/MisReparaciones"><i class='bx bx-wrench'></i> Reparaciones</a>
                            <a class="qa" href="index.php?route=Tecnico/MisRepuestos"><i class='bx bx-package'></i> Repuestos</a>
                            <a class="qa" href="index.php?route=Tecnico/MisStats"><i class='bx bx-line-chart'></i> Estadísticas</a>
                        <?php elseif ($role === 'supervisor'): ?>
                            <a class="qa" href="index.php?route=Supervisor/Presupuestos"><i class='bx bx-wallet'></i> Presupuestos</a>
                            <a class="qa" href="index.php?route=Supervisor/GestionInventario"><i class='bx bx-cabinet'></i> Inventario</a>
                            <a class="qa" href="index.php?route=Supervisor/Asignar"><i class='bx bx-user-voice'></i> Asignar técnico</a>
                        <?php elseif ($role === 'administrador'): ?>
                            <a class="qa" href="index.php?route=Admin/ListarUsers"><i class='bx bx-user'></i> Usuarios</a>
                            <a class="qa" href="index.php?route=Historial/ListarHistorial"><i class='bx bx-history'></i> Historial</a>
                            <a class="qa" href="index.php?route=EstadoTicket/ListarEstados"><i class='bx bx-slider'></i> Estados</a>
                        <?php endif; ?>
                    </div>
                </aside>

                <!-- AYUDA -->
                <section class="help card-wide">
                    <h3><i class='bx bx-question-mark'></i> ¿Necesitás ayuda?</h3>
                    <p>Contactá al soporte o revisá la documentación rápida.</p>
                    <a class="home-link" href="index.php?route=Default/Guia"><i class='bx bx-help-circle'></i> Ir a soporte</a>
                </section>
            </div>
        </div>

        <footer class="footer">
            <small>© <span id="year"></span> Innovasys — Portal</small>
        </footer>
    </div>

    <script>
        document.getElementById('year').textContent = new Date().getFullYear();
        const active = document.getElementById('activeTickets');
        let n = parseInt(active.textContent, 10);
        setInterval(() => {
            n = n + (Math.random() > .7 ? 1 : 0);
            active.textContent = n;
        }, 6000);
    </script>
</main>
