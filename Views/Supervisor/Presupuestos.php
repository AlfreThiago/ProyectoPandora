<?php include_once __DIR__ . '/../Includes/Sidebar.php'; ?>
<main>
<?php include_once __DIR__ . '/../Includes/Header.php'; ?>
    <div class="Contenedor">
        <section class="section-presupuestos">
            <form method="get" action="/ProyectoPandora/Public/index.php" class="presu-filtros">
                <input type="hidden" name="route" value="Supervisor/Presupuestos">
                <label for="ticket_id">Ticket ID</label>
                <input type="number" name="ticket_id" id="ticket_id" min="1" value="<?= htmlspecialchars($_GET['ticket_id'] ?? '') ?>" class="asignar-input asignar-input--small"/>
                <button class="btn btn-outline" type="submit">Filtrar</button>
                <a href="/ProyectoPandora/Public/index.php?route=Supervisor/Presupuestos" class="btn btn-outline">Limpiar</a>
            </form>

            <?php if (empty($presupuestos)): ?>
                <p>No hay datos de tickets para mostrar.</p>
            <?php else: ?>
                <div class="presu-list">
                    <?php foreach ($presupuestos as $p): $t = $p['ticket']; ?>
                        <div class="presu-card">
                            <div class="presu-head">
                                <h3>#<?= (int)$t['id'] ?> - <?= htmlspecialchars($t['dispositivo'] ?? ($t['marca'] ?? '')) ?> <?= htmlspecialchars($t['modelo'] ?? '') ?></h3>
                                <div class="presu-meta">
                                    <span>Cliente: <?= htmlspecialchars($t['cliente'] ?? '') ?></span>
                                    <span>Estado: <?= htmlspecialchars($t['estado'] ?? '') ?></span>
                                </div>
                            </div>
                            <div class="presu-body">
                                <table class="presu-table">
                                    <thead>
                                        <tr>
                                            <th>Ítem</th><th>Categoría</th><th>Cant.</th><th>Unitario</th><th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($p['items'])): ?>
                                            <tr><td colspan="5">Sin repuestos utilizados</td></tr>
                                        <?php else: ?>
                                            <?php foreach ($p['items'] as $it): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($it['name_item']) ?></td>
                                                    <td><?= htmlspecialchars($it['categoria']) ?></td>
                                                    <td><?= (int)$it['cantidad'] ?></td>
                                                    <td>$<?= number_format((float)$it['valor_unitario'], 2, '.', ',') ?></td>
                                                    <td>$<?= number_format((float)$it['valor_total'], 2, '.', ',') ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                                <div class="presu-totales">
                                    <div>Subtotal repuestos: <strong>$<?= number_format($p['subtotal_items'], 2, '.', ',') ?></strong></div>
                                    <?php 
                                        
                                        $sEstado = strtolower(trim($t['estado'] ?? ''));
                                        $laborDef = (float)($p['mano_obra'] ?? 0) > 0;
                                        $editable = (in_array($sEstado, ['diagnóstico','diagnostico']) && !$laborDef);
                                    ?>
                                    <form method="post" action="/ProyectoPandora/Public/index.php?route=Tecnico/ActualizarStats" class="presu-labor" style="display:flex;gap:8px;align-items:center;flex-wrap:wrap;">
                                        <input type="hidden" name="ticket_id" value="<?= (int)$t['id'] ?>"/>
                                        <label>Mano de obra:</label>
                                        <?php if ($editable): ?>
                                            <input type="number" name="labor_amount" step="0.01" min="0" value="<?= number_format((float)$p['mano_obra'], 2, '.', '') ?>" class="asignar-input asignar-input--small"/>
                                            <button class="btn btn-primary" type="submit">Guardar</button>
                                        <?php else: ?>
                                            <span><strong>$<?= number_format((float)$p['mano_obra'], 2, '.', ',') ?></strong></span>
                                            <button class="btn btn-primary" type="submit" disabled>Guardar</button>
                                            <span class="badge badge--muted"><?= $laborDef ? 'Ya definida' : 'Solo en Diagnóstico' ?></span>
                                        <?php endif; ?>
                                    </form>
                                    <div>Total: <strong>$<?= number_format($p['total'], 2, '.', ',') ?></strong></div>
                                        <?php $ready = ($p['subtotal_items'] > 0 || true) && ($p['mano_obra'] > 0); ?>
                                        <form method="post" action="/ProyectoPandora/Public/index.php?route=Ticket/PublicarPresupuesto" style="margin-top:8px;display:flex;gap:8px;align-items:center;">
                                                                                    <input type="hidden" name="ticket_id" value="<?= (int)$t['id'] ?>"/>
                                        <button class="btn btn-outline" type="submit" <?= $ready ? '' : 'disabled' ?>>Publicar presupuesto</button>
                                        <?php if (!$ready): ?>
                                            <span class="badge badge--muted">Faltan datos: <?= $p['mano_obra'] <= 0 ? 'mano de obra' : '' ?></span>
                                        <?php endif; ?>
                                    </form>
                                                                        <?php 
                                                                            $s = strtolower(trim($t['estado'] ?? ''));
                                                                            $puedeListo = in_array($s, ['en reparación','en reparacion','en pruebas']);
                                                                            $puedePagar = ($s === 'listo para retirar');
                                                                        ?>
                                                                        <div style="display:flex; gap:8px; flex-wrap:wrap; margin-top:8px;">
                                                                            <?php if ($puedeListo): ?>
                                                                            <form method="post" action="/ProyectoPandora/Public/index.php?route=Ticket/MarcarListoParaRetirar">
                                                                                <input type="hidden" name="ticket_id" value="<?= (int)$t['id'] ?>" />
                                                                                <button class="btn btn-primary" type="submit">Marcar listo para retirar</button>
                                                                            </form>
                                                                            <?php endif; ?>
                                                                            <?php if ($puedePagar): ?>
                                                                            <form method="post" action="/ProyectoPandora/Public/index.php?route=Ticket/MarcarPagadoYFinalizar">
                                                                                <input type="hidden" name="ticket_id" value="<?= (int)$t['id'] ?>" />
                                                                                <button class="btn btn-success" type="submit">Registrar pago y finalizar</button>
                                                                            </form>
                                                                            <?php endif; ?>
                                                                        </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
    </div>
</main>

