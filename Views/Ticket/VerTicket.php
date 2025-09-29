<?php include_once __DIR__ . '/../Includes/Sidebar.php'; ?>
<main>
    <div class="contenedor" style="max-width:600px;margin:auto; position:relative;">
        <h2 id="tituloDetalle">Detalle del Ticket</h2>
        <?php if (!empty($ticket)): ?>
            <ul class="list-group" id="detalleTicket" style="list-style:none;padding:0;">
                <li><strong>ID Ticket:</strong> <?= htmlspecialchars($ticket['id']) ?></li>
                <li><strong>Dispositivo:</strong> <?= htmlspecialchars($ticket['marca']) ?> <?= htmlspecialchars($ticket['modelo']) ?></li>
                <li><strong>Cliente:</strong> <?= htmlspecialchars($ticket['cliente'] ?? $ticket['cliente_nombre'] ?? $ticket['user_name'] ?? 'No disponible') ?></li>
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
                <li><strong>Descripción de la falla:</strong> <?= htmlspecialchars($ticket['descripcion'] ?? $ticket['descripcion_falla']) ?></li>
                <li><strong>Técnico asignado:</strong> <?= !empty($ticket['tecnico']) ? htmlspecialchars($ticket['tecnico']) : '<span style="color:#d32f2f;">Sin asignar</span>' ?></li>
                <?php if (isset($ticket['fecha_creacion'])): ?>
                    <li class="date-ver"><strong>Fecha de creación:</strong> <?= htmlspecialchars($ticket['fecha_creacion']) ?></li>
                <?php endif; ?>
                <?php if (isset($ticket['fecha_cierre']) && $ticket['fecha_cierre']): ?>
                    <li><strong>Fecha de cierre:</strong> <?= htmlspecialchars($ticket['fecha_cierre']) ?></li>
                <?php endif; ?>
                <?php if (isset($ticket['img_dispositivo'])): ?>
                    <li class="date-ver">
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
        <?php if (isset($_GET['ok']) && $_GET['ok']==='pagado'): ?>
            <div class="alert alert-success" style="margin-top:10px;">Pago registrado. Ticket finalizado.</div>
        <?php endif; ?>
    <?php 
        $estadoTxt = strtolower(trim($ticket['estado'] ?? $ticket['estado_actual'] ?? ''));
        $finalizado = in_array($estadoTxt, ['finalizado','cerrado']);
    ?>
    <?php if (!empty($ticket) && ($rol === 'Cliente') && !empty($ticket['tecnico']) && !$finalizado): ?>
        <div class="alert alert-info" style="margin:12px 0;">Podrás calificar al técnico cuando el ticket esté finalizado.</div>
    <?php endif; ?>
    <?php if (!empty($ticket) && ($rol === 'Cliente')): ?>
        <?php $estadoNow = strtolower(trim($ticket['estado'] ?? $ticket['estado_actual'] ?? '')); $enPresu = ($estadoNow === 'presupuesto' || $estadoNow === 'en espera'); ?>
    <?php if ($enPresu): ?>
                        <?php 
                            require_once __DIR__ . '/../../Core/Database.php';
                            require_once __DIR__ . '/../../Models/ItemTicket.php';
                            require_once __DIR__ . '/../../Models/TicketLabor.php';
                            $dbp = new Database(); $dbp->connectDatabase();
                            $itemM = new ItemTicketModel($dbp->getConnection());
                            $laborM = new TicketLaborModel($dbp->getConnection());
                            $itemsC = $itemM->listarPorTicket((int)$ticket['id']);
                            $subtotalC = 0.0; foreach ($itemsC as $it) { $subtotalC += (float)($it['valor_total'] ?? 0); }
                            $laborC = (array)$laborM->getByTicket((int)$ticket['id']);
                            $manoC = (float)($laborC['labor_amount'] ?? 0);
                            $totalC = $subtotalC + $manoC;
                        ?>
                        <?php $msgPrefix = ($estadoNow === 'presupuesto') ? 'Presupuesto publicado por' : 'Presupuesto preparado por'; ?>
                        <div class="alert alert-info" style="margin:12px 0;">
                            <?= $msgPrefix ?> <strong>$<?= number_format($totalC, 2, '.', ',') ?></strong>. Revisa el detalle y decide cómo proceder.
                            <?php if ($estadoNow === 'en espera'): ?> <span style="opacity:.9;">(pendiente de publicación del supervisor)</span><?php endif; ?>
                        </div>
                        <div class="Tabla-Contenedor" style="margin:10px 0;">
                                <table>
                                        <thead><tr><th>Ítem</th><th>Categoría</th><th>Cant.</th><th>Subtotal</th></tr></thead>
                                        <tbody>
                                                <?php if (empty($itemsC)): ?>
                                                    <tr><td colspan="4">Sin repuestos</td></tr>
                                                <?php else: foreach ($itemsC as $it): ?>
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
                                        <div>Subtotal repuestos: <strong>$<?= number_format($subtotalC, 2, '.', ',') ?></strong></div>
                                        <div>Mano de obra: <strong>$<?= number_format($manoC, 2, '.', ',') ?></strong>
                                            <?php if ($manoC <= 0): ?>
                                                <span class="badge badge--muted" style="margin-left:8px;">Falta definir mano de obra</span>
                                            <?php endif; ?>
                                        </div>
                                        <div>Total: <strong>$<?= number_format($totalC, 2, '.', ',') ?></strong></div>
                                </div>
                        </div>
            <?php if ($estadoNow === 'presupuesto'): ?>
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
    <?php endif; ?>
    <?php if (!empty($ticket) && ($rol === 'Cliente') && !empty($ticket['tecnico']) && $finalizado): ?>
        <hr>
        <h3>Calificar atención del técnico</h3>
        <form method="post" action="/ProyectoPandora/Public/index.php?route=Ticket/Calificar">
            <input type="hidden" name="ticket_id" value="<?= (int)$ticket['id'] ?>"/>
            <label>Estrellas:</label>
            <div class="rating">
                <input type="radio" id="star5" name="stars" value="5"/>
                <label for="star5" class="star">&#9733;</label>
                <input type="radio" id="star4" name="stars" value="4"/>
                <label for="star4" class="star">&#9733;</label>
                <input type="radio" id="star3" name="stars" value="3"/>
                <label for="star3" class="star">&#9733;</label>
                <input type="radio" id="star2" name="stars" value="2"/>
                <label for="star2" class="star">&#9733;</label>
                <input type="radio" id="star1" name="stars" value="1"/>
                <label for="star1" class="star">&#9733;</label>
            </div>
            <label>Comentario (opcional):</label>
            <input type="text" name="comment" class="asignar-input asignar-input--small" placeholder="Tu experiencia"/>
            <button class="btn btn-primary-submit" type="submit">Enviar</button>
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
                <?php 
                    $estadoActualTxt = $estadoStr;
                    $s = strtolower(trim($estadoActualTxt));
                    $bloquearCambio = ($s==='presupuesto' || $s==='en espera');
                    $allowedTargets = [];
                    if ($s==='nuevo') $allowedTargets = ['Diagnóstico','En espera','Cancelado'];
                    elseif ($s==='diagnóstico' || $s==='diagnostico') $allowedTargets = ['Presupuesto','En espera'];
                    elseif ($s==='en reparación' || $s==='en reparacion') $allowedTargets = ['En pruebas','Finalizado'];
                    elseif ($s==='en pruebas') $allowedTargets = ['Finalizado'];
                    elseif ($s==='listo para retirar') $allowedTargets = ['Finalizado'];

                    $targets = [];
                    foreach ($estados as $e) {
                        foreach ($allowedTargets as $name) {
                            if (strcasecmp($e['name'],$name)===0) { $targets[] = $e; break; }
                        }
                    }
                ?>
                <?php if ($bloquearCambio): ?>
                        <div class="alert alert-warning" style="margin-top:8px;">Los cambios de estado están bloqueados mientras el presupuesto está en revisión/publicación.</div>
                        <div class="alert alert-info" style="margin-top:6px;">Define repuestos y mano de obra, y espera a que el supervisor publique el presupuesto. Luego, el cliente deberá aprobarlo.</div>
                <?php elseif (empty($targets)): ?>
                        <div class="alert alert-warning" style="margin-top:8px;">No hay transiciones disponibles desde el estado actual.</div>
                                <?php 
                                    
                                    $msg = '';
                                    if ($s==='presupuesto') $msg = 'Pendiente de decisión del cliente tras la publicación del supervisor.';
                                    elseif ($s==='en espera') $msg = 'Presupuesto listo; el supervisor debe publicarlo para que el cliente lo vea.';
                                    elseif ($s==='finalizado') $msg = 'El ticket está finalizado; no hay más cambios de estado.';
                                    elseif ($s==='cancelado') $msg = 'El ticket fue cancelado; no hay más cambios de estado.';
                                    if ($msg) echo '<div class="alert alert-info" style="margin-top:6px;">'.$msg.'</div>';
                                ?>
                <?php else: ?>
                    <form method="post" action="/ProyectoPandora/Public/index.php?route=Ticket/ActualizarEstado">
                            <input type="hidden" name="ticket_id" value="<?= (int)$ticket['id'] ?>" />
                            <label>Nuevo estado:</label>
                            <select name="estado_id" class="asignar-input asignar-input--small" required>
                                    <option value="" disabled selected>Seleccione un estado</option>
                                    <?php foreach ($targets as $e): ?>
                                            <option value="<?= (int)$e['id'] ?>"><?= htmlspecialchars($e['name']) ?></option>
                                    <?php endforeach; ?>
                            </select>
                            <label>Comentario (opcional):</label>
                            <input type="text" name="comentario" class="asignar-input asignar-input--small" placeholder="Motivo o detalle"/>
                            <button class="btn btn-primary" type="submit">Actualizar</button>
                    </form>
                                <?php 
                                    
                                    $hint = '';
                                    if ($s==='nuevo') $hint = 'Puedes iniciar el diagnóstico, dejar en espera o cancelar.';
                                    elseif ($s==='diagnóstico' || $s==='diagnostico') $hint = 'Define presupuesto o deja en espera si necesitas insumos/info.';
                                    elseif ($s==='en reparación' || $s==='en reparacion') $hint = 'Al terminar, pasa a En pruebas o Finalizado.';
                                    elseif ($s==='en pruebas') $hint = 'Finaliza si todo está correcto.';
                                    if ($hint) echo '<div class="alert alert-info" style="margin-top:6px;">'.$hint.'</div>';
                                ?>
                <?php endif; ?>
        <?php 
          
          require_once __DIR__ . '/../../Core/Database.php';
          require_once __DIR__ . '/../../Models/TecnicoStats.php';
          $db2 = new Database(); $db2->connectDatabase();
          
          $stmtT2 = $db2->getConnection()->prepare("SELECT tc.id AS tecnico_id, ts.labor_min, ts.labor_max FROM tickets t LEFT JOIN tecnicos tc ON t.tecnico_id = tc.id LEFT JOIN tecnico_stats ts ON ts.tecnico_id = tc.id WHERE t.id = ? LIMIT 1");
          $tid = (int)$ticket['id'];
          $tecnicoStats = ['labor_min'=>0,'labor_max'=>0];
          if ($stmtT2) { $stmtT2->bind_param('i',$tid); $stmtT2->execute(); $rowS = $stmtT2->get_result()->fetch_assoc(); if ($rowS){ $tecnicoStats['labor_min']=(float)($rowS['labor_min']??0); $tecnicoStats['labor_max']=(float)($rowS['labor_max']??0);} }
        ?>
        <div style="margin-top:12px;">
            <h4>Mano de obra</h4>
            <div style="font-size:12px;opacity:.8;margin-bottom:6px;">Rango sugerido: $<?= number_format($tecnicoStats['labor_min'], 2, '.', ',') ?> a $<?= number_format($tecnicoStats['labor_max'], 2, '.', ',') ?></div>
                        <?php 
                            
                            require_once __DIR__ . '/../../Models/ItemTicket.php';
                            $itmDb = new Database(); $itmDb->connectDatabase();
                            $itmM = new ItemTicketModel($itmDb->getConnection());
                            $itemsTech = $itmM->listarPorTicket((int)$ticket['id']);
                            $hasItemsTech = !empty($itemsTech);
                            
                            require_once __DIR__ . '/../../Models/TicketLabor.php';
                            $lbM = new TicketLaborModel($itmDb->getConnection());
                            $lbR = $lbM->getByTicket((int)$ticket['id']);
                            $laborActual = (float)($lbR['labor_amount'] ?? 0);
                            $hasLaborTech = $laborActual > 0;
                            $ready = $hasItemsTech && $hasLaborTech;
                            $sEstado = strtolower(trim($estadoStr));
                        ?>
                        <div class="alert <?= $ready ? 'alert-success':'alert-warning' ?>" style="margin-bottom:8px;">
                            <?= $ready ? 'Presupuesto listo para publicar.' : 'Para preparar el presupuesto: agrega repuestos y define mano de obra.' ?>
                        </div>
            <?php if (($sEstado === 'diagnóstico' || $sEstado === 'diagnostico') && !$hasLaborTech): ?>
                <form method="post" action="/ProyectoPandora/Public/index.php?route=Tecnico/ActualizarStats" class="presu-labor">
                    <input type="hidden" name="ticket_id" value="<?= (int)$ticket['id'] ?>"/>
                    <label>Importe:</label>
                    <input type="number" name="labor_amount" step="0.01" min="<?= $tecnicoStats['labor_min'] > 0 ? number_format($tecnicoStats['labor_min'],2,'.','') : '0' ?>" <?= $tecnicoStats['labor_max'] > 0 ? 'max="'.number_format($tecnicoStats['labor_max'],2,'.','').'"' : '' ?> class="asignar-input asignar-input--small" required />
                    <button class="btn btn-primary" type="submit">Guardar mano de obra</button>
                </form>
            <?php else: ?>
                <div class="alert alert-info" style="margin-top:6px;">Mano de obra <?= $hasLaborTech ? 'definida' : 'no disponible para edición' ?><?= $hasLaborTech ? ': <strong>$'.number_format($laborActual,2,'.',',').'</strong>' : '' ?>. <?= ($sEstado!=='diagnóstico' && $sEstado!=='diagnostico') ? 'Solo editable durante Diagnóstico.' : 'Una vez definida no puede modificarse.' ?></div>
            <?php endif; ?>
        </div>
        <?php if (isset($_GET['error']) && $_GET['error']==='presupuesto'): ?>
            <div class="alert alert-error" style="margin-top:8px;">Antes de pasar a "En reparación" define items y mano de obra en Presupuestos.</div>
        <?php elseif (isset($_GET['error']) && $_GET['error']==='transicion'): ?>
            <div class="alert alert-error" style="margin-top:8px;">Transición de estado no permitida.</div>
        <?php elseif (isset($_GET['ok']) && $_GET['ok']==='estado'): ?>
            <div class="alert alert-success" style="margin-top:8px;">Estado actualizado.</div>
        <?php elseif (isset($_GET['ok']) && $_GET['ok']==='labor'): ?>
            <div class="alert alert-success" style="margin-top:8px;">Mano de obra guardada.</div>
        <?php elseif (isset($_GET['error']) && $_GET['error']==='labor_estado'): ?>
            <div class="alert alert-warning" style="margin-top:8px;">La mano de obra solo puede definirse durante el estado Diagnóstico.</div>
        <?php elseif (isset($_GET['error']) && $_GET['error']==='labor_locked'): ?>
            <div class="alert alert-warning" style="margin-top:8px;">La mano de obra ya fue definida y no puede modificarse.</div>
        <?php endif; ?>
        <?php if (isset($_GET['ok']) && $_GET['ok']==='aprobado'): ?>
            <div class="alert alert-success" style="margin-top:8px;">Presupuesto aprobado. El técnico podrá continuar con la reparación.</div>
        <?php elseif (isset($_GET['ok']) && $_GET['ok']==='rechazado'): ?>
            <div class="alert alert-warning" style="margin-top:8px;">Presupuesto rechazado. El ticket ha sido marcado como cancelado.</div>
        <?php endif; ?>
    <?php endif; ?>

        <?php 
            $prev = $_SESSION['prev_url'] ?? '';
            $isPrevJson = strpos($prev, 'Ticket/EstadoJson') !== false;
            $backHref = $isPrevJson ? $volverUrl : ($prev ?: $volverUrl);
        ?>
        <?php if (isset($_GET['ok']) && $_GET['ok']==='listo'): ?>
            <div class="alert alert-success" style="margin-top:10px;">Equipo listo para retirar.</div>
        <?php endif; ?>

        <?php if (!empty($ticket) && ($rol === 'Supervisor')): ?>
            <hr>
            <h3>Acciones del supervisor</h3>
            <?php $sSup = strtolower(trim($estadoStr)); ?>
            <?php if (in_array($sSup, ['en reparación','en reparacion','en pruebas'])): ?>
                <form method="post" action="/ProyectoPandora/Public/index.php?route=Ticket/MarcarListoParaRetirar" style="display:inline-block;margin-right:8px;">
                    <input type="hidden" name="ticket_id" value="<?= (int)$ticket['id'] ?>" />
                    <button class="btn btn-primary" type="submit">Marcar listo para retirar</button>
                </form>
            <?php endif; ?>
            <?php if ($sSup === 'listo para retirar'): ?>
                <form method="post" action="/ProyectoPandora/Public/index.php?route=Ticket/MarcarPagadoYFinalizar" style="display:inline-block;">
                    <input type="hidden" name="ticket_id" value="<?= (int)$ticket['id'] ?>" />
                    <button class="btn btn-success" type="submit">Registrar pago y finalizar</button>
                </form>
            <?php endif; ?>
        <?php endif; ?>

        <a href="<?= htmlspecialchars($backHref) ?>" class="btn btn-secondary mt-3">Volver</a>

        <?php 
            
            $mostrarPagadoOverlay = false;
            if ((isset($_GET['ok']) && $_GET['ok']==='pagado') || $finalizado) {
                require_once __DIR__ . '/../../Core/Database.php';
                require_once __DIR__ . '/../../Models/Rating.php';
                $dbx = new Database(); $dbx->connectDatabase();
                $rtM = new RatingModel($dbx->getConnection());
                $rt = $rtM->getByTicket((int)$ticket['id']);
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
            
            require_once __DIR__ . '/../../Models/TicketEstadoHistorial.php';
            require_once __DIR__ . '/../../Core/Database.php';
            $db = new Database(); $db->connectDatabase();
            $th = new TicketEstadoHistorialModel($db->getConnection());
            $events = $th->listByTicket((int)$ticket['id']);
        ?>
        <div class="Tabla-Contenedor" style="margin-top:14px;">
            <h3 style="margin-bottom:10px;color:#fff;">Línea de tiempo</h3>
            <div class="timeline-2col" style="display:grid; grid-template-columns: 1fr 1fr 1fr; gap:12px;">
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
                <div>
                    <strong style="color:#fff;">Supervisor</strong>
                    <ul style="list-style:none; padding:0; margin-top:8px;">
                        <?php foreach ($events as $ev): if ($ev['user_role']!=='Supervisor') continue; ?>
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
        fetch(`/ProyectoPandora/Public/index.php?route=Ticket/EstadoJson&id=${id}&ajax=1`, {cache:'no-store', headers:{'Accept':'application/json'}})
            .then(r=>r.ok?r.json():null)
            .then(d=>{ if(!d||!d.estado) return; badge.textContent = d.estado; badge.className = classFor(d.estado); });
    };
    setInterval(tick, 20000);
})();
</script>
