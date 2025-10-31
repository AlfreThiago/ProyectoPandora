<?php include_once __DIR__ . '/../Includes/Sidebar.php'; ?>
<?php require_once __DIR__ . '/../../Core/Date.php'; ?>
<main>
<?php include_once __DIR__ . '/../Includes/Header.php'; ?>

<div class="Contenedor">
    <form method="get" action="/ProyectoPandora/Public/index.php" class="filtros" style="display:flex;gap:10px;flex-wrap:wrap;margin:10px 0;align-items:center;">
        <input type="hidden" name="route" value="Cliente/MisTicketTerminados" />
        <?php $estadoSel = strtolower($_GET['estado'] ?? 'finalizados'); ?>
        <select name="estado" class="asignar-input asignar-input--small">
            <option value="finalizados" <?= $estadoSel==='finalizados'?'selected':'' ?>>Finalizados</option>
            <option value="activos" <?= $estadoSel==='activos'?'selected':'' ?>>Activos</option>
            <option value="todos" <?= $estadoSel==='todos'?'selected':'' ?>>Todos</option>
        </select>
        <input name="q" value="<?= htmlspecialchars($_GET['q'] ?? '') ?>" class="asignar-input asignar-input--small" type="text" placeholder="Buscar..." />
        <input name="desde" value="<?= htmlspecialchars($_GET['desde'] ?? '') ?>" class="asignar-input asignar-input--small" type="date" />
        <input name="hasta" value="<?= htmlspecialchars($_GET['hasta'] ?? '') ?>" class="asignar-input asignar-input--small" type="date" />
        <button class="btn btn-primary" type="submit">Filtrar</button>
        <a class="btn btn-outline" href="/ProyectoPandora/Public/index.php?route=Cliente/MisTicketTerminados">Limpiar</a>
    </form>

    <section class="section-mis-tickets">
        <h2 class="titulo-carrusel">Tickets Finalizados</h2>

        <div class="carousel-container carousel-container-tecnico">
            <button class="carousel-btn-tecnico prev-btn-tecnico" id="prevTicketBtnFinished">&#10094;</button>

            <div class="carousel-track-tecnico" id="carouselTicketTrackFinished">
                <?php if (!empty($tickets)): ?>
                    <?php foreach ($tickets as $ticket): ?>
                        <?php 
                            $estadoStr = $ticket['estado'] ?? ''; 
                            $estadoClass = $ticket['estadoClass'] ?? 'badge'; 
                            $imgUrl = !empty($ticket['imagen']) 
                                ? htmlspecialchars($ticket['imagen']) 
                                : '/ProyectoPandora/Public/assets/img/default-device.jpg';
                        ?>
                        <div class="ticket-card">

                            <div class="ticket-info">
                                <h3><?= htmlspecialchars($ticket['dispositivo']) ?> <?= htmlspecialchars($ticket['modelo']) ?></h3>
                                <p class="line-clamp-3"><strong>Descripción:</strong> <?= htmlspecialchars($ticket['descripcion_falla']) ?></p>
                                <p><strong>Estado:</strong> <span class="<?= $estadoClass ?>"><?= htmlspecialchars($estadoStr) ?></span></p>
                                <p><strong>Fecha:</strong> <time title="<?= htmlspecialchars($ticket['fecha_exact'] ?? '') ?>"><?= htmlspecialchars($ticket['fecha_human'] ?? '') ?></time></p>
                                <p><strong>Técnico:</strong> <?= htmlspecialchars($ticket['tecnico'] ?? 'Sin asignar') ?></p>
                            </div>

                            <div class="ticket-actions">
                                <a href="/ProyectoPandora/Public/index.php?route=Ticket/Ver&id=<?= (int)$ticket['id'] ?>" class="btn">Ver detalle</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No tienes tickets finalizados o cancelados.</p>
                <?php endif; ?>
            </div>

            <button class="carousel-btn-tecnico next-btn-tecnico" id="nextTicketBtnFinished">&#10095;</button>
        </div>
    </section>
</div>

</main>

<script>
const ticketTrackFinished = document.getElementById('carouselTicketTrackFinished');
const prevTicketBtnFinished = document.getElementById('prevTicketBtnFinished');
const nextTicketBtnFinished = document.getElementById('nextTicketBtnFinished');

const ticketCardWidthFinished = 300; // ancho aproximado de cada tarjeta + margen

nextTicketBtnFinished.addEventListener('click', () => {
  ticketTrackFinished.scrollBy({ left: ticketCardWidthFinished, behavior: 'smooth' });
});

prevTicketBtnFinished.addEventListener('click', () => {
  ticketTrackFinished.scrollBy({ left: -ticketCardWidthFinished, behavior: 'smooth' });
});
</script>
