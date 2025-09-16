<?php include_once __DIR__ . '/../Includes/Sidebar.php'; ?>
<?php
// Verificamos el rol logueado desde la sesión
$rol = $_SESSION['user']['role'] ?? null;

switch ($rol) {
    case 'Administrador':
        include_once __DIR__ . '/../Admin/PanelAdmin.php';
        break;
    case 'Tecnico':
        include_once __DIR__ . '/../Paneles/PanelTecnico.php';
        break;
    case 'Supervisor':
        include_once __DIR__ . '/../Paneles/PanelSupervisor.php';
        break;
    case 'Cliente':
        include_once __DIR__ . '/../Clientes/PanelCliente.php';
        break;
    default:
        echo "<p>No tienes un rol asignado o el rol no es válido.</p>";
        break;
}
?>
<main>
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
                            <div class="device-info">
                                <h3><?= htmlspecialchars($device['marca']) ?> <?= htmlspecialchars($device['modelo']) ?></h3>
                                <p><strong>Descripción:</strong> <?= htmlspecialchars($device['descripcion_falla']) ?></p>
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
.btn-float-add {
    position: fixed;
    bottom: 20px;
    right: 20px;
    width: 60px;
    height: 60px;
    background: #007bff;
    color: #fff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    text-decoration: none;
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    transition: background 0.3s, transform 0.3s;
}
.btn-float-add:hover {
    background: #0056b3;
    transform: translateY(-2px);
}
</style>

<?php include_once __DIR__ . '/../Includes/Footer.php' ?>