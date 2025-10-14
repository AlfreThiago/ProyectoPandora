<?php include_once __DIR__ . '/../Includes/Sidebar.php'; ?>
<?php require_once __DIR__ . '/../../Core/Date.php'; ?>
<main>
<?php include_once __DIR__ . '/../Includes/Header.php'; ?>
    <div class="Contenedor">
        <section class="section-mis-devices">
            <div class="cards-container">
                <?php if (!empty($dispositivos)): ?>
                    <?php foreach ($dispositivos as $d): ?>
  <article class="device-card">
    <div class="device-img">
        <img src="/ProyectoPandora/Public/img/imgDispositivos/<?= htmlspecialchars($d['img_dispositivo']) ?>" alt="Imagen dispositivo">
    </div>
    <div class="device-info u-flex-col u-flex-1">
        <h3><?= htmlspecialchars($d['marca']) ?> <?= htmlspecialchars($d['modelo']) ?></h3>
        <p class="line-clamp-3"><strong>Descripción:</strong> <?= htmlspecialchars($d['descripcion_falla']) ?></p>
        <p><strong>Categoría:</strong> <?= htmlspecialchars($d['categoria']) ?></p>
    <p><strong>Fecha agregado:</strong> 
      <time title="<?= htmlspecialchars(DateHelper::exact($d['fecha_registro'] ?? '')) ?>">
        <?= htmlspecialchars(DateHelper::smart($d['fecha_registro'] ?? '')) ?>
      </time>
    </p>
    </div>
    <div class="device-card__actions">
      <?php if (empty($d['has_active_ticket'])): ?>
        <form method="post" action="/ProyectoPandora/Public/index.php?route=Device/Eliminar"
              onsubmit="return confirm('¿Eliminar este dispositivo? Esta acción no se puede deshacer.');"
              style="display:inline-block">
          <input type="hidden" name="device_id" value="<?= (int)$d['id'] ?>">
          <button type="submit" class="btn btn-danger">Eliminar</button>
        </form>
      <?php else: ?>
        <span class="badge badge-warn">No disponible: ticket activo</span>
      <?php endif; ?>
    </div>
  </article>
<?php endforeach; ?>
                <?php else: ?>
                    <p>No tienes dispositivos registrados.</p>
                <?php endif; ?>
            </div>
        </section>
    </div>
</main>

<a href="/ProyectoPandora/Public/index.php?route=Device/MostrarCrearDispositivo" class="btn-float-add" title="Agregar dispositivo">
    +
</a>

