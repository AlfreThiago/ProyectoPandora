<?php include_once __DIR__ . '/../Includes/Sidebar.php'; ?>
<?php require_once __DIR__ . '/../../Core/Date.php'; ?>
<main>
<?php include_once __DIR__ . '/../Includes/Header.php'; ?>
        <section class="content">

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
                            <div class="device-info u-flex-col u-flex-1">
                                <h3><?= htmlspecialchars($ticket['marca']) ?> <?= htmlspecialchars($ticket['modelo']) ?></h3>
                                <p><strong>Cliente:</strong> <?= htmlspecialchars($ticket['cliente']) ?></p>
                                <p class="line-clamp-3"><strong>Descripción:</strong> <?= htmlspecialchars($ticket['descripcion_falla']) ?></p>
                                <p><strong>Estado:</strong> <?= htmlspecialchars($ticket['estado']) ?></p>
                                <p><strong>Fecha:</strong> <time title="<?= htmlspecialchars(DateHelper::exact($ticket['fecha_creacion'] ?? '')) ?>"><?= htmlspecialchars(DateHelper::smart($ticket['fecha_creacion'] ?? '')) ?></time></p>
                                <div class="card-actions">
                                    <a href="/ProyectoPandora/Public/index.php?route=Ticket/Ver&id=<?= $ticket['id'] ?>" class="btn btn-primary">Ver detalle</a>
                                </div>
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
 