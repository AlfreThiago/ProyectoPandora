<?php include_once __DIR__ . '/../Includes/Sidebar.php'; ?>
<main>
    <div class="contenedor" style="max-width:600px;margin:auto; position:relative;">
        <h2 id="tituloDetalle">Detalle del Ticket</h2>

        <?php if (!empty($view['ticket'])): ?>
            <?php $t = $view['ticket']; ?>
            <ul class="list-group" id="detalleTicket" style="list-style:none;padding:0;">
                <li><strong>ID Ticket:</strong> <?= htmlspecialchars($t['id']) ?></li>
                <li><strong>Dispositivo:</strong> <?= htmlspecialchars($t['marca']) ?> <?= htmlspecialchars($t['modelo']) ?></li>
                <li><strong>Cliente:</strong> <?= htmlspecialchars($t['cliente'] ?? $t['cliente_nombre'] ?? $t['user_name'] ?? 'No disponible') ?></li>
                <li><strong>Estado:</strong> <span id="estado-badge" class="<?= htmlspecialchars($view['estadoClass']) ?>"><?= htmlspecialchars($view['estadoStr']) ?></span></li>
                <li><strong>Descripción de la falla:</strong> <?= htmlspecialchars($t['descripcion'] ?? $t['descripcion_falla']) ?></li>
                <li><strong>Técnico asignado:</strong> <?= !empty($t['tecnico']) ? htmlspecialchars($t['tecnico']) : '<span style="color:#d32f2f;">Sin asignar</span>' ?></li>
                <?php if (isset($t['fecha_creacion'])): ?><li class="date-ver"><strong>Fecha de creación:</strong> <?= htmlspecialchars($t['fecha_creacion']) ?></li><?php endif; ?>
                <?php if (!empty($t['fecha_cierre'])): ?><li><strong>Fecha de cierre:</strong> <?= htmlspecialchars($t['fecha_cierre']) ?></li><?php endif; ?>
                <?php if (!empty($t['img_dispositivo'])): ?>
                    <li class="date-ver">
                      <strong>Imagen del dispositivo:</strong><br>
                      <img src="/ProyectoPandora/Public/img/imgDispositivos/<?= htmlspecialchars($t['img_dispositivo']) ?>" style="max-width:180px;border-radius:8px;">
                    </li>
                <?php endif; ?>
            </ul>
        <?php else: ?>
            <div class="alert alert-danger">No se encontró información para este ticket.</div>
        <?php endif; ?>

        <?php if (!empty($view['flash']['error']) && $view['flash']['error']==='estado'): ?>
            <div class="alert alert-warning" style="margin-top:10px;">Solo puedes calificar cuando el ticket esté finalizado.</div>
        <?php endif; ?>
        <?php if (!empty($view['flash']['error']) && $view['flash']['error']==='aprobacion'): ?>
            <div class="alert alert-warning" style="margin-top:10px;">Aún falta que el cliente apruebe el presupuesto.</div>
        <?php endif; ?>
        <?php if (!empty($view['flash']['ok']) && $view['flash']['ok']==='aprobado'): ?>
            <div class="alert alert-success" style="margin-top:10px;">Presupuesto aprobado. El técnico podrá continuar con la reparación.</div>
        <?php elseif (!empty($view['flash']['ok']) && $view['flash']['ok']==='rechazado'): ?>
            <div class="alert alert-warning" style="margin-top:10px;">Presupuesto rechazado. El ticket ha sido marcado como cancelado.</div>
        <?php endif; ?>
        <?php if (!empty($view['flash']['ok']) && $view['flash']['ok']==='pagado'): ?>
            <div class="alert alert-success" style="margin-top:10px;">Pago registrado. Ticket finalizado.</div>
        <?php endif; ?>

        <?php
            $rol = $view['rol'] ?? '';
            $finalizado = !empty($view['finalizado']);
            $estadoLower = strtolower(trim($view['estadoStr'] ?? ''));
        ?>

        <?php if (!empty($view['ticket']) && $rol === 'Cliente' && !empty($view['ticket']['tecnico']) && !$finalizado): ?>
            <div class="alert alert-info" style="margin:12px 0;">Podrás calificar al técnico cuando el ticket esté finalizado.</div>
        <?php endif; ?>

        <?php if (!empty($view['ticket']) && $rol === 'Cliente'): ?>
            <?php if (!empty($view['enPresu'])): ?>
                <?php $p = $view['presupuesto']; ?>
                <?php $msgPrefix = ($estadoLower === 'presupuesto') ? 'Presupuesto publicado por' : 'Presupuesto preparado por'; ?>
                <div class="alert alert-info" style="margin:12px 0;">
                    <?= $msgPrefix ?> <strong>$<?= number_format((float)$p['total'], 2, '.', ',') ?></strong>.
                    <?php if ($estadoLower === 'en espera'): ?> <span style="opacity:.9;">(pendiente de publicación del supervisor)</span><?php endif; ?>
                </div>
                <div class="Tabla-Contenedor" style="margin:10px 0;">
                    <table>
                        <thead><tr><th>Ítem</th><th>Categoría</th><th>Cant.</th><th>Subtotal</th></tr></thead>
                        <tbody>
                        <?php if (empty($p['items'])): ?>
                            <tr><td colspan="4">Sin repuestos</td></tr>
                        <?php else: foreach ($p['items'] as $it): ?>
                            <tr>
                                <td><?= htmlspecialchars($it['name_item']) ?></td>
                                <td><?= htmlspecialchars($it['categoria']) ?></td>
                                <td><?= (int)$it['cantidad'] ?></td>
                                <td>$<?= number_format((float)$it['valor_total'], 2, '.', ',') ?></td>
                            </tr>
                        <?php endforeach; endif; ?>
                        </tbody>
                    </table>
                    <div style="margin-top:8px;display:flex;gap:16px;align-items:center;flex-wrap:wrap;">
                        <div>Subtotal repuestos: <strong>$<?= number_format((float)$p['subtotal'], 2, '.', ',') ?></strong></div>
                        <div>Mano de obra: <strong>$<?= number_format((float)$p['mano_obra'], 2, '.', ',') ?></strong>
                            <?php if ((float)$p['mano_obra'] <= 0): ?>
                                <span class="badge badge--muted" style="margin-left:8px;">Falta definir mano de obra</span>
                            <?php endif; ?>
                        </div>
                        <div>Total: <strong>$<?= number_format((float)$p['total'], 2, '.', ',') ?></strong></div>
                    </div>
                </div>

                <?php if ($estadoLower === 'presupuesto'): ?>
                <form method="post" action="/ProyectoPandora/Public/index.php?route=Ticket/AprobarPresupuesto" style="display:inline-block;margin-right:8px;">
                    <input type="hidden" name="ticket_id" value="<?= (int)$view['ticket']['id'] ?>" />
                    <input type="hidden" name="comentario" value="Aprobado por el cliente" />
                    <button class="btn btn-success" type="submit">Aprobar</button>
                </form>
                <form method="post" action="/ProyectoPandora/Public/index.php?route=Ticket/RechazarPresupuesto" style="display:inline-block;">
                    <input type="hidden" name="ticket_id" value="<?= (int)$view['ticket']['id'] ?>" />
                    <input type="hidden" name="comentario" value="Rechazado por el cliente" />
                    <button class="btn btn-danger" type="submit">Rechazar</button>
                </form>
                <?php endif; ?>
            <?php endif; ?>
        <?php endif; ?>

        <?php if (!empty($view['ticket']) && $rol === 'Cliente' && !empty($view['ticket']['tecnico']) && $finalizado): ?>
            <hr>
            <h3>Calificar atención del técnico</h3>
            <form method="post" action="/ProyectoPandora/Public/index.php?route=Ticket/Calificar">
                <input type="hidden" name="ticket_id" value="<?= (int)$view['ticket']['id'] ?>"/>
                <label>Estrellas:</label>
                <div class="rating">
                    <input type="radio" id="star5" name="stars" value="5"/><label for="star5" class="star">&#9733;</label>
                    <input type="radio" id="star4" name="stars" value="4"/><label for="star4" class="star">&#9733;</label>
                    <input type="radio" id="star3" name="stars" value="3"/><label for="star3" class="star">&#9733;</label>
                    <input type="radio" id="star2" name="stars" value="2"/><label for="star2" class="star">&#9733;</label>
                    <input type="radio" id="star1" name="stars" value="1"/><label for="star1" class="star">&#9733;</label>
                </div>
                <label>Comentario (opcional):</label>
                <input type="text" name="comment" class="asignar-input asignar-input--small" placeholder="Tu experiencia"/>
                <button class="btn btn-primary-submit" type="submit">Enviar</button>
            </form>
        <?php endif; ?>

        <?php if (!empty($view['ticket']) && $rol === 'Tecnico'): ?>
            <hr>
            <h3>Cambiar estado</h3>

            <?php if (!empty($view['tecnico']['acciones'])): ?>
                <?php foreach ($view['tecnico']['acciones'] as $accion): ?>
                    <form method="post" action="/ProyectoPandora/Public/index.php?route=Ticket/ActualizarEstado" style="margin-bottom:8px;">
                        <input type="hidden" name="ticket_id" value="<?= (int)$view['ticket']['id'] ?>" />
                        <input type="hidden" name="estado_id" value="<?= (int)$accion['estado_id'] ?>" />
                        <input type="hidden" name="comentario" value="<?= htmlspecialchars($accion['comentario'], ENT_QUOTES, 'UTF-8') ?>" />
                        <button class="btn btn-primary" type="submit"><?= htmlspecialchars($accion['label']) ?></button>
                    </form>
                <?php endforeach; ?>
            <?php endif; ?>
            <?php if (!empty($view['tecnico']['mensaje'])): ?>
                <div class="alert <?= empty($view['tecnico']['acciones']) ? 'alert-warning' : 'alert-info' ?>" style="margin-top:6px;"><?= htmlspecialchars($view['tecnico']['mensaje']) ?></div>
            <?php endif; ?>

            <div style="margin-top:12px;">
                <h4>Mano de obra</h4>
                <div style="font-size:12px;opacity:.8;margin-bottom:6px;">Rango sugerido: $<?= number_format((float)$view['tecnico']['labor_min'], 2, '.', ',') ?> a $<?= number_format((float)$view['tecnico']['labor_max'], 2, '.', ',') ?></div>

                <?php $ready = !empty($view['tecnico']['has_items']) && !empty($view['tecnico']['has_labor']); ?>
                <div class="alert <?= $ready ? 'alert-success':'alert-warning' ?>" style="margin-bottom:8px;">
                    <?= $ready ? 'Presupuesto listo para publicar.' : 'Para preparar el presupuesto: agrega repuestos y define mano de obra.' ?>
                </div>

                <?php if (!empty($view['tecnico']['labor_editable'])): ?>
                    <form method="post" action="/ProyectoPandora/Public/index.php?route=Tecnico/ActualizarStats" class="presu-labor">
                        <input type="hidden" name="ticket_id" value="<?= (int)$view['ticket']['id'] ?>"/>
                        <label>Importe:</label>
                        <input type="number" name="labor_amount" step="0.01"
                               min="<?= $view['tecnico']['labor_min'] > 0 ? number_format((float)$view['tecnico']['labor_min'],2,'.','') : '0' ?>"
                               <?= $view['tecnico']['labor_max'] > 0 ? 'max="'.number_format((float)$view['tecnico']['labor_max'],2,'.','').'"' : '' ?>
                               class="asignar-input asignar-input--small" required />
                        <button class="btn btn-primary" type="submit">Guardar mano de obra</button>
                    </form>
                <?php else: ?>
                    <?php $lb = (float)($view['presupuesto']['mano_obra'] ?? 0); ?>
                    <div class="alert alert-info" style="margin-top:6px;">
                        Mano de obra <?= $lb > 0 ? 'definida' : 'no disponible para edición' ?><?= $lb > 0 ? ': <strong>$'.number_format($lb,2,'.',',').'</strong>' : '' ?>.
                        <?= ($estadoLower!=='diagnóstico' && $estadoLower!=='diagnostico') ? 'Solo editable durante Diagnóstico.' : 'Una vez definida no puede modificarse.' ?>
                    </div>
                <?php endif; ?>
            </div>

            <?php if (!empty($view['flash']['error']) && $view['flash']['error']==='presupuesto'): ?>
                <div class="alert alert-error" style="margin-top:8px;">Antes de pasar a "En reparación" define items y mano de obra en Presupuestos.</div>
            <?php elseif (!empty($view['flash']['error']) && $view['flash']['error']==='transicion'): ?>
                <div class="alert alert-error" style="margin-top:8px;">Transición de estado no permitida.</div>
            <?php elseif (!empty($view['flash']['ok']) && $view['flash']['ok']==='estado'): ?>
                <div class="alert alert-success" style="margin-top:8px;">Estado actualizado.</div>
            <?php elseif (!empty($view['flash']['ok']) && $view['flash']['ok']==='labor'): ?>
                <div class="alert alert-success" style="margin-top:8px;">Mano de obra guardada.</div>
            <?php elseif (!empty($view['flash']['error']) && $view['flash']['error']==='labor_estado'): ?>
                <div class="alert alert-warning" style="margin-top:8px;">La mano de obra solo puede definirse durante el estado Diagnóstico.</div>
            <?php elseif (!empty($view['flash']['error']) && $view['flash']['error']==='labor_locked'): ?>
                <div class="alert alert-warning" style="margin-top:8px;">La mano de obra ya fue definida y no puede modificarse.</div>
            <?php endif; ?>

            <?php if (!empty($view['flash']['ok']) && $view['flash']['ok']==='aprobado'): ?>
                <div class="alert alert-success" style="margin-top:8px;">Presupuesto aprobado. El técnico podrá continuar con la reparación.</div>
            <?php elseif (!empty($view['flash']['ok']) && $view['flash']['ok']==='rechazado'): ?>
                <div class="alert alert-warning" style="margin-top:8px;">Presupuesto rechazado. El ticket ha sido marcado como cancelado.</div>
            <?php endif; ?>
        <?php endif; ?>

        <?php if (!empty($view['ticket']) && $rol === 'Supervisor'): ?>
            <hr>
            <h3>Acciones del supervisor</h3>
            <?php if (!empty($view['supervisor']['puede_listo'])): ?>
                <form method="post" action="/ProyectoPandora/Public/index.php?route=Ticket/MarcarListoParaRetirar" style="display:inline-block;margin-right:8px;">
                    <input type="hidden" name="ticket_id" value="<?= (int)$view['ticket']['id'] ?>" />
                    <button class="btn btn-primary" type="submit">Marcar listo para retirar</button>
                </form>
            <?php endif; ?>
            <?php if (!empty($view['supervisor']['puede_finalizar'])): ?>
                <form method="post" action="/ProyectoPandora/Public/index.php?route=Ticket/MarcarPagadoYFinalizar" style="display:inline-block;">
                    <input type="hidden" name="ticket_id" value="<?= (int)$view['ticket']['id'] ?>" />
                    <button class="btn btn-success" type="submit">Registrar pago y finalizar</button>
                </form>
            <?php endif; ?>
        <?php endif; ?>

        <a href="<?= htmlspecialchars($view['backHref'] ?? '/ProyectoPandora/Public/index.php?route=Default/Index') ?>" class="btn btn-secondary mt-3">Volver</a>

        <?php
            $mostrarPagadoOverlay = false;
            if ((!empty($view['flash']['ok']) && $view['flash']['ok']==='pagado') || $finalizado) {
                require_once __DIR__ . '/../../Core/Database.php';
                require_once __DIR__ . '/../../Models/Rating.php';
                $dbx = new Database(); $dbx->connectDatabase();
                $rtM = new RatingModel($dbx->getConnection());
                $rt = $rtM->getByTicket((int)$view['ticket']['id']);
                $mostrarPagadoOverlay = !empty($rt) && (int)($rt['stars'] ?? 0) > 0;
                if (!$mostrarPagadoOverlay && $finalizado && $rol === 'Cliente') {
                    echo '<div class="alert alert-warning" style="margin-top:10px;">Tu ticket está finalizado. Por favor, califica la atención para completar el cierre.</div>';
                }
            }
        ?>
        <?php if ($mostrarPagadoOverlay): ?>
        <div style="position:absolute; inset:0; display:flex; align-items:center; justify-content:center; background:rgba(0,0,0,.45); z-index:5;">
            <div style="background:#e8f5e9; color:#2e7d32; border:2px solid #2e7d32; padding:18px 28px; border-radius:10px; font-weight:700; font-size:22px; box-shadow:0 6px 20px rgba(0,0,0,.25);">
                PAGADO
            </div>
        </div>
        <?php endif; ?>
    </div>

    <?php
        $timeline = $view['timeline'] ?? ['Tecnico'=>[], 'Cliente'=>[], 'Supervisor'=>[]];
    ?>
    <div class="Tabla-Contenedor" style="margin-top:14px;">
        <h3 style="margin-bottom:10px;color:#fff;">Línea de tiempo</h3>
        <div class="timeline-2col" style="display:grid; grid-template-columns: 1fr 1fr 1fr; gap:12px;">
            <div>
                <strong style="color:#fff;">Técnico</strong>
                <ul style="list-style:none; padding:0; margin-top:8px;">
                    <?php foreach ($timeline['Tecnico'] as $ev): ?>
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
                    <?php foreach ($timeline['Cliente'] as $ev): ?>
                        <li style="margin-bottom:8px;">
                            <div style="font-size:12px; opacity:.8; color:#fff;"><?= htmlspecialchars($ev['created_at']) ?></div>
                            <div style="color:#fff;">Estado: <span class="badge badge--muted"><?= htmlspecialchars($ev['estado']) ?></span></div>
                            <?php if (!empty($ev['comentario'])): ?><div style="opacity:.9;color:#fff;">"<?= htmlspecialchars($ev['comentario']) ?>"</div><?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div>
                <strong style="color:#fff;">Supervisor</strong>
                <ul style="list-style:none; padding:0; margin-top:8px;">
                    <?php foreach ($timeline['Supervisor'] as $ev): ?>
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
    const id = <?= (int)($view['ticket']['id'] ?? 0) ?>;
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
        fetch(`/ProyectoPandora/Public/index.php?route=Ticket/EstadoJson&id=${id}&ajax=1`, {cache:'no-store', headers:{'Accept':'application/json'}})
            .then(r=>r.ok?r.json():null)
            .then(d=>{ if(!d||!d.estado) return; badge.textContent = d.estado; badge.className = classFor(d.estado); });
    };
    setInterval(tick, 20000);
})();
</script>
