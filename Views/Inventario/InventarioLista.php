<?php include_once __DIR__ . '/../Includes/Sidebar.php'; ?>

<main>
<?php include_once __DIR__ . '/../Includes/Header.php'; ?>
    <div class="Tabla-Contenedor">
        <h2>Lista de Inventario</h2>
        <?php if ($rol === 'Supervisor'): ?>
        <div class="botones">
            <div class="btn-table-acciones">
                <a class="btn-acciones-inventario" href="/ProyectoPandora/Public/index.php?route=Inventario/MostrarCrearItem">Añadir Item</a>
            </div>
        </div>
        <?php endif; ?>
        <table id="inventarioTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Img</th>
                    <th>Categoría</th>
                    <th>Item</th>
                    <th>Precio Unit.</th>
                    <th>Cantidad</th>
                    <th>Stock Mínimo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($items)): ?>
                    <?php foreach ($items as $row): ?>
                        <?php $low = (int)$row['stock_actual'] <= (int)$row['stock_minimo']; ?>
                        <tr class="<?php echo $low ? 'row-low-stock' : ''; ?>">
                            <td><?php echo (int)$row['id']; ?></td>
                            <td>
                                <?php
                                    $foto = $row['foto_item'] ?? '';
                                    $imgSrc = $foto
                                        ? '/ProyectoPandora/Public/img/imgInventario/' . $foto
                                        : '/ProyectoPandora/Public/img/imgInventario/images.jpg';
                                ?>
                                <img class="inv-thumb" src="<?php echo htmlspecialchars($imgSrc); ?>" alt="<?php echo htmlspecialchars($row['name_item']); ?>"/>
                            </td>
                            <td><?php echo htmlspecialchars($row['categoria']); ?></td>
                            <td><?php echo htmlspecialchars($row['name_item']); ?></td>
                            <td>$<?php echo number_format((float)$row['valor_unitario'], 2); ?></td>
                            <td><?php echo (int)$row['stock_actual']; ?></td>
                            <td><?php echo (int)$row['stock_minimo']; ?></td>
                            <td>
                                <?php if ($rol === 'Supervisor'): ?>
                                    <form action="/ProyectoPandora/Public/index.php?route=Inventario/SumarStock" method="post" style="display:flex; gap:6px; align-items:center;">
                                        <input type="hidden" name="id" value="<?php echo (int)$row['id']; ?>" />
                                        <input type="number" name="cantidad" min="1" class="asignar-input asignar-input--small" placeholder="+cantidad" required />
                                        <button class="btn btn-primary" type="submit">Sumar</button>
                                    </form>
                                    <div style="margin-top:6px;">
                                        <a href="/ProyectoPandora/Public/index.php?route=Inventario/Eliminar&id=<?php echo (int)$row['id']; ?>" class="btn delete-btn" onclick="return confirm('¿Seguro que deseas eliminar este item?');">Eliminar</a>
                                    </div>
                                <?php else: ?>
                                    <em>Solo lectura</em>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="8">No hay items en el inventario.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>
<?php include_once __DIR__ . '/../Includes/Footer.php' ?>