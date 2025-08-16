<?php
require_once __DIR__ . '/../Controllers/HistorialController.php';

$historialController = new HistorialController();
$historial = $historialController->obtenerHistorial();

foreach ($historial as $movimiento) {
    echo "<p>{$movimiento['accion']} - {$movimiento['detalle']} - {$movimiento['create_at']}</p>";
}
