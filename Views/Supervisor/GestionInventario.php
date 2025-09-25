<?php include_once __DIR__ . '/../Includes/Sidebar.php'; ?>

<main class="inv-page">
<?php include_once __DIR__ . '/../Includes/Header.php'; ?>
  <section class="content asignar-content">
    <section class="content asignar-content">
			<section class="content">

        
			</section>


    <?php if (isset($_GET['success'])): ?>
      <div class="alert alert-success">Operación realizada correctamente.</div>
    <?php elseif (isset($_GET['error'])): ?>
      <div class="alert alert-error">No se pudo completar la operación.</div>
    <?php endif; ?>

    <div class="asignar-panel">
      <div class="Tabla-Contenedor">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
          <h2 style="margin:0;">Stock actual</h2>
          <a class="btn btn-outline" href="/ProyectoPandora/Public/index.php?route=Inventario/MostrarCrearItem">Agregar nuevo item</a>
        </div>
        <table>
          <thead>
            <tr>
              <th>ID</th>
              <th>Img</th>
              <th>Categoria</th>
              <th>Item</th>
              <th>Precio Unit.</th>
              <th>Stock</th>
			  <th>Stock Mínimo</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach (($items ?? []) as $row): ?>
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
                  <form action="/ProyectoPandora/Public/index.php?route=Inventario/SumarStock" method="post" style="display:flex; gap:6px; align-items:center;">
                    <input type="hidden" name="id" value="<?php echo (int)$row['id']; ?>" />
                    <input type="number" name="cantidad" min="1" class="asignar-input asignar-input--small" placeholder="+cantidad" required />
                    <button class="btn btn-primary" type="submit">Sumar</button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </section>
</main>
<script src="/ProyectoPandora/Public/js/modal.js"></script>

