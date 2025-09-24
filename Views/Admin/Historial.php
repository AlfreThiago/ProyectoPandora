<?php include_once __DIR__ . '/../Includes/Sidebar.php'; ?>
<main>
    <div class="timeline">
        <?php foreach ($historial as $movimiento): ?>
            <div class="timeline-item">
                <span class="time"><?php echo $movimiento['fecha']; ?></span>
                <p><b><?php echo $movimiento['acciones']; ?></b> - <?php echo $movimiento['detalles']; ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</main>