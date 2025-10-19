<?php include_once __DIR__ . '/../Includes/Sidebar.php'; ?>
<?php require_once __DIR__ . '/../../Core/Date.php'; ?>
<main>
<?php include_once __DIR__ . '/../Includes/Header.php'; ?>
    <div class="Contenedor">
        <section class="section-mis-tickets">
            <div class="cards-container">
                <?php if (!empty($tickets)): ?>
                    <?php foreach ($tickets as $ticket): ?>
                        <?php $estadoStr = $ticket['estado'] ?? ''; $estadoClass = $ticket['estadoClass'] ?? 'badge'; ?>
                        <div class="device-card">
                            <div class="device-info u-flex-col u-flex-1">
                                <h3><?= htmlspecialchars($ticket['dispositivo']) ?> <?= htmlspecialchars($ticket['modelo']) ?></h3>
                                <p class="line-clamp-3"><strong>Descripción:</strong> <?= htmlspecialchars($ticket['descripcion_falla']) ?></p>
                                <p><strong>Estado:</strong> <span class="estado <?= strtolower(str_replace(' ', '-', $ticket['estado'])) ?>"><?= htmlspecialchars($estadoStr) ?></span></p>
                                <p><strong>Fecha:</strong> <time title="<?= htmlspecialchars(DateHelper::exact($ticket['fecha_creacion'] ?? '')) ?>"><?= htmlspecialchars(DateHelper::smart($ticket['fecha_creacion'] ?? '')) ?></time></p>
                                <p><strong>Técnico:</strong> <?= htmlspecialchars($ticket['tecnico'] ?? 'Sin asignar') ?></p>
                                <div class="card-actions">
                                    <a href="/ProyectoPandora/Public/index.php?route=Ticket/Ver&id=<?= (int)$ticket['id'] ?>" class="btn btn-primary">Ver detalle</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No tienes tickets finalizados o cancelados.</p>
                <?php endif; ?>
            </div>
        </section>
    </div>
</main>
