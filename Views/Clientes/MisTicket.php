<?php include_once __DIR__ . '/../Includes/Sidebar.php'; ?>
<?php require_once __DIR__ . '/../../Core/Date.php'; ?>
<main>
<?php include_once __DIR__ . '/../Includes/Header.php'; ?>
    <div class="Contenedor">
        <section class="section-mis-tickets">
            <div class="cards-container">
                <?php if (!empty($tickets)): ?>
                    <?php foreach ($tickets as $ticket): ?>
                        <div class="device-card">
                            <div class="device-info u-flex-col u-flex-1">
                                <h3><?= htmlspecialchars($ticket['dispositivo']) ?> <?= htmlspecialchars($ticket['modelo']) ?></h3>
                                <p class="line-clamp-3"><strong>Descripción:</strong> <?= htmlspecialchars($ticket['descripcion_falla']) ?></p>
                                <?php 
                                    $estadoStr = $ticket['estado'] ?? '';
                                    $estadoLower = strtolower($estadoStr);
                                    $estadoClass = 'badge badge--muted';
                                    if (in_array($estadoLower, ['abierto','nuevo','recibido'])) $estadoClass = 'badge';
                                    if (in_array($estadoLower, ['en proceso','diagnóstico','diagnostico','reparación','reparacion','en reparación'])) $estadoClass = 'badge badge--success';
                                    if (in_array($estadoLower, ['en espera','pendiente'])) $estadoClass = 'badge';
                                    if (in_array($estadoLower, ['finalizado','cerrado','cancelado'])) $estadoClass = 'badge badge--danger';
                                ?>
                                <p><strong>Estado:</strong> <span class="<?= $estadoClass ?>"><?= htmlspecialchars($estadoStr) ?></span></p>
                                <p><strong>Fecha:</strong> <time title="<?= htmlspecialchars(DateHelper::exact($ticket['fecha_creacion'] ?? '')) ?>"><?= htmlspecialchars(DateHelper::smart($ticket['fecha_creacion'] ?? '')) ?></time></p>
                                <p><strong>Técnico:</strong> <?= htmlspecialchars($ticket['tecnico'] ?? 'Sin asignar') ?></p>
                                <div class="card-actions">
                                    <a href="/ProyectoPandora/Public/index.php?route=Ticket/Ver&id=<?= $ticket['id'] ?>" class="btn btn-primary">Ver detalle</a>
                                    <a href="/ProyectoPandora/Public/index.php?route=Ticket/Editar&id=<?= $ticket['id'] ?>" class="btn btn-edit">Editar</a>
                                    <?php if ($estadoLower === 'nuevo'): ?>
                                        <a href="/ProyectoPandora/Public/index.php?route=Ticket/Eliminar&id=<?= (int)$ticket['id'] ?>" class="btn delete-btn" onclick="return confirm('¿Seguro que deseas eliminar este ticket? Esta acción no se puede deshacer.');">Eliminar</a>
                                    <?php endif; ?>
                                </div>
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
