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
    <div class="Tabla-Contenedor">
        <h2>Lista de Tickets</h2>
        <div class="botones">
            
            <div class="btn-table-acciones">
                <a class="btn-acciones-ticket" href="/ProyectoPandora/Public/index.php?route=Ticket/mostrarCrear">Crear TIcket</a>
            </div>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Dispositivo</th>
                    <th>Cliente</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                    <th>Técnico</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="ticketTable">
                <?php if (!empty($data)): ?>
                    <?php foreach ($data as $ticket): ?>
                        <tr>
                            <td><?= htmlspecialchars($ticket['id']) ?></td>
                            <td><?= htmlspecialchars($ticket['dispositivo']) ?></td>
                            <td><?= htmlspecialchars($ticket['cliente']) ?></td>
                            <td><?= htmlspecialchars($ticket['descripcion']) ?></td>
                            <td><?= htmlspecialchars($ticket['estado']) ?></td>
                            <td><?= htmlspecialchars($ticket['tecnico'] ?? 'Sin asignar') ?></td>
                            <td>
                                <div class='action-buttons'>
                                    <!-- Acciones: Ver, Editar, Eliminar, etc. -->
                                    <a class="btn ver-btn"  href="/ProyectoPandora/Public/index.php?route=Ticket/verTicket&id=<?= $ticket['id'] ?>">Ver</a>
                                    |
                                    <a class="btn edit-btn" href="/ProyectoPandora/Public/index.php?route=Ticket/Editar&id=<?= $ticket['id'] ?>">Editar</a>
                                    |
                                    <a class="btn delete-btn" href="/ProyectoPandora/Public/index.php?route=Ticket/Eliminar&id=<?= $ticket['id'] ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar este ticket?');">Eliminar</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="7">No hay tickets registrados.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>
<?php include_once __DIR__ . '/../Includes/Footer.php' ?>