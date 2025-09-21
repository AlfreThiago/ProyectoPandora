<?php include_once __DIR__ . '/../Includes/Sidebar.php'; ?>
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
                            <div class="device-info">
                                <h3><?= htmlspecialchars($ticket['marca']) ?> <?= htmlspecialchars($ticket['modelo']) ?></h3>
                                <p><strong>Cliente:</strong> <?= htmlspecialchars($ticket['cliente']) ?></p>
                                <p><strong>Descripción:</strong> <?= htmlspecialchars($ticket['descripcion_falla']) ?></p>
                                <p><strong>Estado:</strong> <?= htmlspecialchars($ticket['estado']) ?></p>
                                <p><strong>Fecha:</strong> <?= htmlspecialchars($ticket['fecha_creacion']) ?></p>
                                <a href="/ProyectoPandora/Public/index.php?route=Ticket/Ver&id=<?= $ticket['id'] ?>" class="btn btn-primary" style="margin-top:8px;">Ver detalle</a>
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
<style>
.cards-container {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: flex-start;
}
.device-card {
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    width: 260px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    transition: box-shadow 0.2s;
}
.device-card:hover {
    box-shadow: 0 4px 16px rgba(0,0,0,0.15);
}
.device-img img {
    width: 100%;
    height: 140px;
    object-fit: cover;
    border-bottom: 1px solid #eee;
}
.device-info {
    padding: 16px;
}
.device-info h3 {
    margin: 0 0 8px 0;
    font-size: 1.1em;
    color: #333;
}
.device-info p {
    margin: 4px 0;
    font-size: 0.95em;
    color: #555;
}
.btn.btn-primary {
    background: #007bff;
    color: #fff;
    padding: 6px 12px;
    border-radius: 4px;
    text-decoration: none;
    display: inline-block;
    font-size: 0.95em;
    transition: background 0.2s;
}
.btn.btn-primary:hover {
    background: #0056b3;
}
</style>
<?php include_once __DIR__ . '/../Includes/Footer.php' ?>