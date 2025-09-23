<?php include_once __DIR__ . '/../Includes/Sidebar.php'; ?>
<main>
<?php include_once __DIR__ . '/../Includes/Header.php'; ?>
    <div class="Contenedor">
        <section class="section-mis-devices">
            <h2>Mis Dispositivos</h2>
            <div class="cards-container">
                <?php if (!empty($dispositivos)): ?>
                    <?php foreach ($dispositivos as $device): ?>
                        <div class="device-card">
                            <div class="device-img">
                                <img src="/ProyectoPandora/Public/img/imgDispositivos/<?= htmlspecialchars($device['img_dispositivo']) ?>" alt="Imagen dispositivo">
                            </div>
                            <div class="device-info u-flex-col u-flex-1">
                                <h3><?= htmlspecialchars($device['marca']) ?> <?= htmlspecialchars($device['modelo']) ?></h3>
                                <p class="line-clamp-3"><strong>Descripción:</strong> <?= htmlspecialchars($device['descripcion_falla']) ?></p>
                                <p><strong>Categoría:</strong> <?= htmlspecialchars($device['categoria']) ?></p>
                                <p><strong>Fecha agregado:</strong> <?= htmlspecialchars($device['fecha_registro'] ?? '') ?></p>
                            </div>
                        </div>
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

