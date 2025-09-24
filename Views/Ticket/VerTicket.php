<?php include_once __DIR__ . '/../Includes/Sidebar.php'; ?>
<main>
    <div class="contenedor" style="max-width:600px;margin:auto;">
        <h2 id="tituloDetalle">Detalle del Ticket</h2>
        <?php if (!empty($ticket)): ?>
            <ul class="list-group" id="detalleTicket" style="list-style:none;padding:0;">
                <li><strong>ID Ticket:</strong> <?= htmlspecialchars($ticket['id']) ?></li>
                <li><strong>Dispositivo:</strong> <?= htmlspecialchars($ticket['marca']) ?> <?= htmlspecialchars($ticket['modelo']) ?></li>
                <li><strong>Cliente:</strong> <?= htmlspecialchars($ticket['cliente'] ?? $ticket['cliente_nombre'] ?? $ticket['user_name'] ?? 'No disponible') ?></li>
                <li><strong>Descripción de la falla:</strong> <?= htmlspecialchars($ticket['descripcion'] ?? $ticket['descripcion_falla']) ?></li>
                <?php 
                    $estadoStr = $ticket['estado'] ?? $ticket['estado_actual'] ?? 'No disponible';
                    $estadoLower = strtolower($estadoStr);
                    $estadoClass = 'badge badge--muted';
                    if (in_array($estadoLower, ['abierto','nuevo','recibido'])) $estadoClass = 'badge';
                    if (in_array($estadoLower, ['en proceso','diagnóstico','diagnostico','reparación','reparacion','en reparación'])) $estadoClass = 'badge badge--success';
                    if (in_array($estadoLower, ['en espera','pendiente'])) $estadoClass = 'badge';
                    if (in_array($estadoLower, ['finalizado','cerrado','cancelado'])) $estadoClass = 'badge badge--danger';
                ?>
                <li><strong>Estado:</strong> <span id="estado-badge" class="<?= $estadoClass ?>"><?= htmlspecialchars($estadoStr) ?></span></li>
                <li><strong>Técnico asignado:</strong> <?= !empty($ticket['tecnico']) ? htmlspecialchars($ticket['tecnico']) : '<span style="color:#d32f2f;">Sin asignar</span>' ?></li>
                <?php if (isset($ticket['fecha_creacion'])): ?>
                    <li><strong>Fecha de creación:</strong> <?= htmlspecialchars($ticket['fecha_creacion']) ?></li>
                <?php endif; ?>
                <?php if (isset($ticket['fecha_cierre']) && $ticket['fecha_cierre']): ?>
                    <li><strong>Fecha de cierre:</strong> <?= htmlspecialchars($ticket['fecha_cierre']) ?></li>
                <?php endif; ?>
                <?php if (isset($ticket['img_dispositivo'])): ?>
                    <li>
                      <strong>Imagen del dispositivo:</strong><br>
                      <img src="/ProyectoPandora/Public/img/imgDispositivos/<?= htmlspecialchars($ticket['img_dispositivo']) ?>" style="max-width:180px;border-radius:8px;">
                    </li>
                <?php endif; ?>
            </ul>
        <?php else: ?>
            <div class="alert alert-danger">No se encontró información para este ticket.</div>
        <?php endif; ?>

        <?php
        $user = Auth::user();
        $rol = $user['role'] ?? '';
        if ($rol === 'Cliente') {
            $volverUrl = "/ProyectoPandora/Public/index.php?route=Cliente/MisTicket";
        } elseif ($rol === 'Tecnico') {
            $volverUrl = "/ProyectoPandora/Public/index.php?route=Tecnico/MisReparaciones";
        } elseif ($rol === 'Supervisor') {
            $volverUrl = "/ProyectoPandora/Public/index.php?route=Supervisor/Asignar";
        } elseif ($rol === 'Administrador') {
            $volverUrl = "/ProyectoPandora/Public/index.php?route=Admin/ListarUsers";
        } else {
            $volverUrl = "/ProyectoPandora/Public/index.php?route=Default/Index";
        }
        ?>
        <?php if (isset($_GET['error']) && $_GET['error'] === 'estado'): ?>
            <div class="alert alert-warning" style="margin-top:10px;">Solo puedes calificar cuando el ticket esté finalizado.</div>
        <?php endif; ?>
        <?php if (isset($_GET['error']) && $_GET['error'] === 'aprobacion'): ?>
            <div class="alert alert-warning" style="margin-top:10px;">Aún falta que el cliente apruebe el presupuesto.</div>
        <?php endif; ?>
        <?php if (isset($_GET['ok']) && $_GET['ok']==='aprobado'): ?>
            <div class="alert alert-success" style="margin-top:10px;">Presupuesto aprobado. El técnico podrá continuar con la reparación.</div>
        <?php elseif (isset($_GET['ok']) && $_GET['ok']==='rechazado'): ?>
            <div class="alert alert-warning" style="margin-top:10px;">Presupuesto rechazado. El ticket ha sido marcado como cancelado.</div>
        <?php endif; ?>
    <?php 
        $estadoTxt = strtolower(trim($ticket['estado'] ?? $ticket['estado_actual'] ?? ''));
        $finalizado = in_array($estadoTxt, ['finalizado','cerrado']);
    ?>
    <?php if (!empty($ticket) && ($rol === 'Cliente') && !empty($ticket['tecnico']) && !$finalizado): ?>
        <div class="alert alert-info" style="margin:12px 0;">Podrás calificar al técnico cuando el ticket esté finalizado.</div>
    <?php endif; ?>
    <?php if (!empty($ticket) && ($rol === 'Cliente')): ?>
        <?php $enPresu = (strtolower(trim($ticket['estado'] ?? $ticket['estado_actual'] ?? '')) === 'presupuesto'); ?>
        <?php if ($enPresu): ?>
            <div class="alert alert-info" style="margin:12px 0;">Revisa el presupuesto y decide cómo proceder.</div>
            <form method="post" action="/ProyectoPandora/Public/index.php?route=Ticket/AprobarPresupuesto" style="display:inline-block;margin-right:8px;">
                <input type="hidden" name="ticket_id" value="<?= (int)$ticket['id'] ?>" />
                <input type="hidden" name="comentario" value="Aprobado por el cliente" />
                <button class="btn btn-success" type="submit">Aprobar</button>
            </form>
            <form method="post" action="/ProyectoPandora/Public/index.php?route=Ticket/RechazarPresupuesto" style="display:inline-block;">
                <input type="hidden" name="ticket_id" value="<?= (int)$ticket['id'] ?>" />
                <input type="hidden" name="comentario" value="Rechazado por el cliente" />
                <button class="btn btn-danger" type="submit">Rechazar</button>
            </form>
        <?php endif; ?>
    <?php endif; ?>
    <?php if (!empty($ticket) && ($rol === 'Cliente') && !empty($ticket['tecnico']) && $finalizado): ?>
        <hr>
        <h3>Calificar atención del técnico</h3>
        <form method="post" action="/ProyectoPandora/Public/index.php?route=Ticket/Calificar">
            <input type="hidden" name="ticket_id" value="<?= (int)$ticket['id'] ?>"/>
            <label>Estrellas:</label>
            <select name="stars" class="asignar-input asignar-input--small">
                <?php for ($i=1;$i<=5;$i++): ?>
                    <option value="<?= $i ?>"><?= $i ?> ★</option>
                <?php endfor; ?>
            </select>
            <label>Comentario (opcional):</label>
            <input type="text" name="comment" class="asignar-input asignar-input--small" placeholder="Tu experiencia"/>
            <button class="btn btn-primary" type="submit">Enviar</button>
        </form>
    <?php endif; ?>

    <?php if (!empty($ticket) && ($rol === 'Tecnico')): ?>
        <hr>
        <h3>Cambiar estado</h3>
        <?php 
          require_once __DIR__ . '/../../Core/Database.php';
          require_once __DIR__ . '/../../Models/EstadoTicket.php';
          $db = new Database(); $db->connectDatabase();
          $estadoModel = new EstadoTicketModel($db->getConnection());
          $estados = $estadoModel->getAllEstados();
        ?>
        <form method="post" action="/ProyectoPandora/Public/index.php?route=Ticket/ActualizarEstado">
            <input type="hidden" name="ticket_id" value="<?= (int)$ticket['id'] ?>" />
            <label>Nuevo estado:</label>
            <select name="estado_id" class="asignar-input asignar-input--small">
                <?php foreach ($estados as $e): ?>
                    <option value="<?= (int)$e['id'] ?>" <?= (strcasecmp($e['name'],$estadoStr)===0?'selected':'') ?>><?= htmlspecialchars($e['name']) ?></option>
                <?php endforeach; ?>
            </select>
            <label>Comentario (opcional):</label>
            <input type="text" name="comentario" class="asignar-input asignar-input--small" placeholder="Motivo o detalle"/>
            <button class="btn btn-primary" type="submit">Actualizar</button>
        </form>
        <?php if (isset($_GET['error']) && $_GET['error']==='presupuesto'): ?>
            <div class="alert alert-error" style="margin-top:8px;">Antes de pasar a "En reparación" define items y mano de obra en Presupuestos.</div>
        <?php elseif (isset($_GET['error']) && $_GET['error']==='transicion'): ?>
            <div class="alert alert-error" style="margin-top:8px;">Transición de estado no permitida.</div>
        <?php elseif (isset($_GET['ok']) && $_GET['ok']==='estado'): ?>
            <div class="alert alert-success" style="margin-top:8px;">Estado actualizado.</div>
        <?php endif; ?>
        <?php if (isset($_GET['ok']) && $_GET['ok']==='aprobado'): ?>
            <div class="alert alert-success" style="margin-top:8px;">Presupuesto aprobado. El técnico podrá continuar con la reparación.</div>
        <?php elseif (isset($_GET['ok']) && $_GET['ok']==='rechazado'): ?>
            <div class="alert alert-warning" style="margin-top:8px;">Presupuesto rechazado. El ticket ha sido marcado como cancelado.</div>
        <?php endif; ?>
    <?php endif; ?>

    <a href="<?= $_SESSION['prev_url'] ?? htmlspecialchars($volverUrl) ?>" class="btn btn-secondary mt-3">Volver</a>
    </div>
        <?php 
            // Timeline de cambios de estado e interacciones
            require_once __DIR__ . '/../../Models/TicketEstadoHistorial.php';
            require_once __DIR__ . '/../../Core/Database.php';
            $db = new Database(); $db->connectDatabase();
            $th = new TicketEstadoHistorialModel($db->getConnection());
            $events = $th->listByTicket((int)$ticket['id']);
        ?>
        <div class="Tabla-Contenedor" style="margin-top:14px;">
            <h3 style="margin-bottom:10px;color:#fff;">Línea de tiempo</h3>
            <div class="timeline-2col" style="display:grid; grid-template-columns: 1fr 1fr; gap:12px;">
                <div>
                    <strong style="color:#fff;">Técnico</strong>
                    <ul style="list-style:none; padding:0; margin-top:8px;">
                        <?php foreach ($events as $ev): if ($ev['user_role']!=='Tecnico') continue; ?>
                            <li style="margin-bottom:8px;">
                                <div style="font-size:12px; opacity:.8; color:#fff;"><?= htmlspecialchars($ev['created_at']) ?></div>
                                <div style="color:#fff;">Estado: <span class="badge badge--success"><?= htmlspecialchars($ev['estado']) ?></span></div>
                                <?php if (!empty($ev['comentario'])): ?><div style="opacity:.9;color:#fff;">"<?= htmlspecialchars($ev['comentario']) ?>"</div><?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div>
                    <strong style="color:#fff;">Cliente</strong>
                    <ul style="list-style:none; padding:0; margin-top:8px;">
                        <?php foreach ($events as $ev): if ($ev['user_role']!=='Cliente') continue; ?>
                            <li style="margin-bottom:8px;">
                                <div style="font-size:12px; opacity:.8; color:#fff;"><?= htmlspecialchars($ev['created_at']) ?></div>
                                <div style="color:#fff;">Estado: <span class="badge badge--muted"><?= htmlspecialchars($ev['estado']) ?></span></div>
                                <?php if (!empty($ev['comentario'])): ?><div style="opacity:.9;color:#fff;">"<?= htmlspecialchars($ev['comentario']) ?>"</div><?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
</main>

<script>
// Auto-refresh estado cada 20s
(function(){
    const badge = document.getElementById('estado-badge');
    const id = <?= (int)($ticket['id'] ?? 0) ?>;
    if (!badge || !id) return;
    const classFor = (txt)=>{
        const t = (txt||'').toLowerCase();
    if (["finalizado","cerrado","cancelado"].includes(t)) return 'badge badge--danger';
        if (["en proceso","diagnóstico","diagnostico","reparación","reparacion","en reparación"].includes(t)) return 'badge badge--success';
        if (["en espera","pendiente"].includes(t)) return 'badge';
        if (["abierto","nuevo","recibido"].includes(t)) return 'badge';
        return 'badge badge--muted';
    };
    const tick = ()=>{
        fetch(`/ProyectoPandora/Public/index.php?route=Ticket/EstadoJson&id=${id}`, {cache:'no-store'})
            .then(r=>r.ok?r.json():null)
            .then(d=>{ if(!d||!d.estado) return; badge.textContent = d.estado; badge.className = classFor(d.estado); });
    };
    setInterval(tick, 20000);
})();
</script>
