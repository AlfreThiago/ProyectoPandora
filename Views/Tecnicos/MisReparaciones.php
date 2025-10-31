<?php include_once __DIR__ . '/../Includes/Sidebar.php'; ?>
<?php require_once __DIR__ . '/../../Core/Date.php'; ?>
<?php require_once __DIR__ . '/../../Core/Storage.php'; ?>
<main>
<?php include_once __DIR__ . '/../Includes/Header.php'; ?>
<section class="content">

  <div class="Contenedor">
    <form method="get" action="/ProyectoPandora/Public/index.php" class="filtros" style="display:flex;gap:10px;flex-wrap:wrap;margin:10px 0;align-items:center;">
      <input type="hidden" name="route" value="Tecnico/MisReparaciones" />
      <?php $estadoSel = strtolower($_GET['estado'] ?? 'activos'); ?>
      <select name="estado" class="asignar-input asignar-input--small">
        <option value="activos" <?= $estadoSel==='activos'?'selected':'' ?>>Activos</option>
        <option value="finalizados" <?= $estadoSel==='finalizados'?'selected':'' ?>>Finalizados</option>
        <option value="todos" <?= $estadoSel==='todos'?'selected':'' ?>>Todos</option>
      </select>
      <input name="q" value="<?= htmlspecialchars($_GET['q'] ?? '') ?>" class="asignar-input asignar-input--small" type="text" placeholder="Buscar..." />
      <input name="desde" value="<?= htmlspecialchars($_GET['desde'] ?? '') ?>" class="asignar-input asignar-input--small" type="date" />
      <input name="hasta" value="<?= htmlspecialchars($_GET['hasta'] ?? '') ?>" class="asignar-input asignar-input--small" type="date" />
      <button class="btn btn-primary" type="submit">Filtrar</button>
      <a class="btn btn-outline" href="/ProyectoPandora/Public/index.php?route=Tecnico/MisReparaciones">Limpiar</a>
    </form>

    <section class="section-mis-tickets">
  <h2 class="titulo-carrusel">Mis Tickets</h2>

  <div class="carousel-container carousel-container-tecnico">
    <button class="carousel-btn-tecnico prev-btn-tecnico" id="prevTicketBtnTech">&#10094;</button>

    <div class="carousel-track-tecnico" id="carouselTicketTrackTech">
      <?php if (!empty($tickets)): ?>
        <?php foreach ($tickets as $ticket): ?>
          <?php $imgDevice = \Storage::resolveDeviceUrl($ticket['img_dispositivo'] ?? ''); ?>
          <div class="ticket-card">
            <div class="ticket-img">
              <img src="<?= htmlspecialchars($imgDevice) ?>" alt="Imagen dispositivo">
            </div>

            <div class="ticket-info">
              <h3><?= htmlspecialchars($ticket['marca']) ?> <?= htmlspecialchars($ticket['modelo']) ?></h3>
              <p><strong>Cliente:</strong> <?= htmlspecialchars($ticket['cliente']) ?></p>
              <p class="line-clamp-3"><strong>Descripción:</strong> <?= htmlspecialchars($ticket['descripcion_falla']) ?></p>
              <p><strong>Estado:</strong> <span class="<?= $ticket['estadoClass'] ?>"><?= htmlspecialchars($ticket['estado']) ?></span></p>
              <p><strong>Fecha:</strong> <time title="<?= htmlspecialchars($ticket['fecha_exact']) ?>"><?= htmlspecialchars($ticket['fecha_human']) ?></time></p>
            </div>

            <div class="ticket-actions">
              <a href="/ProyectoPandora/Public/index.php?route=Ticket/Ver&id=<?= $ticket['id'] ?>" class="btn">Ver detalle</a>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>No tienes reparaciones asignadas.</p>
      <?php endif; ?>
    </div>

    <button class="carousel-btn-tecnico next-btn-tecnico" id="nextTicketBtnTech">&#10095;</button>
  </div>
</section>

  </div>
</section>
<script>
  const ticketTrackTech = document.getElementById('carouselTicketTrackTech');
const prevTicketBtnTech = document.getElementById('prevTicketBtnTech');
const nextTicketBtnTech = document.getElementById('nextTicketBtnTech');

const ticketCardWidthTech = 300; // ancho aproximado de cada tarjeta + margen

nextTicketBtnTech.addEventListener('click', () => {
  ticketTrackTech.scrollBy({ left: ticketCardWidthTech, behavior: 'smooth' });
});

prevTicketBtnTech.addEventListener('click', () => {
  ticketTrackTech.scrollBy({ left: -ticketCardWidthTech, behavior: 'smooth' });
});

</script>
</main>
