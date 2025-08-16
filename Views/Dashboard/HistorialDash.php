<?php
require_once __DIR__ . '/../../Controllers/HistorialController.php';

$historialController = new HistorialController();
$historial = $historialController->obtenerHistorial();

foreach ($historial as $movimiento) {
    echo "<p>{$movimiento['acciones']} - {$movimiento['detalles']} - {$movimiento['fecha']}</p>";
}
