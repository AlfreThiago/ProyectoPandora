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
        <section class="section-mis-tickets">
            <h2>Mis Tickets</h2>
            <div class="cards-container">
                <?php if (!empty($tickets)): ?>
                    <?php foreach ($tickets as $ticket): ?>
                        <div class="device-card">
                            <div class="device-info">
                                <h3><?= htmlspecialchars($ticket['dispositivo']) ?> <?= htmlspecialchars($ticket['modelo']) ?></h3>
                                <p><strong>Descripción:</strong> <?= htmlspecialchars($ticket['descripcion_falla']) ?></p>
                                <p><strong>Estado:</strong> <?= htmlspecialchars($ticket['estado']) ?></p>
                                <p><strong>Fecha:</strong> <?= htmlspecialchars($ticket['fecha_creacion']) ?></p>
                                <a href="/ProyectoPandora/Public/index.php?route=Ticket/Ver&id=<?= $ticket['id'] ?>" class="btn btn-primary" style="margin-top:8px;">Ver detalle</a>
                                <a href="/ProyectoPandora/Public/index.php?route=Ticket/Editar&id=<?= $ticket['id'] ?>" class="btn btn-edit" style="margin-top:8px;">Editar</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No tienes tickets registrados.</p>
                <?php endif; ?>
            </div>
            <a href="/ProyectoPandora/Public/index.php?route=Ticket/mostrarCrear" class="btn-float-add" title="Agregar ticket">
                +
            </a>
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
.btn-edit {
    background: #ffc107;
    color: #222;
    padding: 6px 12px;
    border-radius: 4px;
    text-decoration: none;
    display: inline-block;
    font-size: 0.95em;
    margin-left: 8px;
    transition: background 0.2s;
    border: none;
}
.btn-edit:hover {
    background: #e0a800;
    color: #fff;
}
.btn-float-add {
    position: fixed;
    bottom: 32px;
    right: 32px;
    background: #28a745;
    color: #fff;
    font-size: 2em;
    width: 56px;
    height: 56px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    box-shadow: 0 2px 8px rgba(0,0,0,0.18);
    transition: background 0.2s;
    z-index: 1000;
}
.btn-float-add:hover {
    background: #218838;
}
</style>

<?php include_once __DIR__ . '/../Includes/Footer.php' ?>