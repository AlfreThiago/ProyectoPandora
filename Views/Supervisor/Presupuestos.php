<?php include_once __DIR__ . '/../Includes/Sidebar.php'; ?>
<main>
<?php include_once __DIR__ . '/../Includes/Header.php'; ?>
    <div class="Contenedor">
        <section class="section-presupuestos">
            <h2>Presupuestos de Tickets</h2>
            <form method="get" action="/ProyectoPandora/Public/index.php" class="presu-filtros">
                <input type="hidden" name="route" value="Supervisor/Presupuestos">
                <label for="ticket_id">Ticket ID</label>
                <input type="number" name="ticket_id" id="ticket_id" min="1" value="<?= htmlspecialchars($_GET['ticket_id'] ?? '') ?>" class="asignar-input asignar-input--small"/>
                <button class="btn btn-primary" type="submit">Filtrar</button>
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
                                                    <td>$<?= number_format((float)$it['valor_unitario'], 2) ?></td>
                                                    <td>$<?= number_format((float)$it['valor_total'], 2) ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                                <div class="presu-totales">
                                    <div>Subtotal repuestos: <strong>$<?= number_format($p['subtotal_items'], 2) ?></strong></div>
                                    <form method="post" action="/ProyectoPandora/Public/index.php?route=Tecnico/ActualizarStats" class="presu-labor">
                                        <input type="hidden" name="ticket_id" value="<?= (int)$t['id'] ?>"/>
                                        <label>Mano de obra:</label>
                                        <input type="number" name="labor_amount" step="0.01" min="0" value="<?= number_format($p['mano_obra'], 2, '.', '') ?>" class="asignar-input asignar-input--small"/>
                                        <button class="btn btn-primary" type="submit">Guardar</button>
                                    </form>
                                    <div>Total: <strong>$<?= number_format($p['total'], 2) ?></strong></div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
    </div>
</main>

