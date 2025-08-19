<?php
require_once __DIR__ . '/../../Controllers/HistorialController.php';
$historialController = new HistorialController();
$historial = $historialController->obtenerHistorial();
?>
<div class="timeline">
    <?php foreach ($historial as $movimiento): ?>
        <div class="timeline-item">
            <span class="time"><?php echo $movimiento['fecha']; ?></span>
            <p><b><?php echo $movimiento['acciones']; ?></b> - <?php echo $movimiento['detalles']; ?></p>
        </div>
    <?php endforeach; ?>
</div>