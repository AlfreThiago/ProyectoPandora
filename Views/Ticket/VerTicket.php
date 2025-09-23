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
                <li><strong>Estado:</strong> <span class="role"><?= htmlspecialchars($ticket['estado'] ?? $ticket['estado_actual'] ?? 'No disponible') ?></span></li>
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
    <?php 
        $estadoTxt = strtolower(trim($ticket['estado'] ?? $ticket['estado_actual'] ?? ''));
        $finalizado = in_array($estadoTxt, ['finalizado','cerrado']);
    ?>
    <?php if (!empty($ticket) && ($rol === 'Cliente') && !empty($ticket['tecnico']) && !$finalizado): ?>
        <div class="alert alert-info" style="margin:12px 0;">Podrás calificar al técnico cuando el ticket esté finalizado.</div>
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

    <a href="<?= $_SESSION['prev_url'] ?? htmlspecialchars($volverUrl) ?>" class="btn btn-secondary mt-3">Volver</a>
    </div>
</main>
