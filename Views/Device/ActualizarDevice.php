<?php include_once __DIR__ . '/../Includes/Sidebar.php' ?>
<main>
    <div class="contenedor">
        <h2>Actualizar Dispositivo</h2>

        <form method="POST" enctype="multipart/form-data" action="/ProyectoPandora/Public/index.php?route=Device/ActualizarDevice&id=<?= $dispositivo['id'] ?>">
            <input type="hidden" name="from" value="<?= $_GET['from'] ?? 'Device/ListarDevices' ?> ">
            <input type="hidden" name="id" value="<?= $dispositivo['id'] ?>">

            <label>Categoría</label>
            <select name="categoria_id" required>
                <option value="">Seleccione una categoría</option>
                <?php foreach ($categorias as $categoria): ?>
                    <option value="<?= $categoria['id'] ?>"
                        <?= ($dispositivo['categoria_id'] == $categoria['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($categoria['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label>Marca</label>
            <input type="text" name="marca" value="<?= htmlspecialchars($dispositivo['marca']) ?>" required>

            <label>Modelo</label>
            <input type="text" name="modelo" value="<?= htmlspecialchars($dispositivo['modelo']) ?>" required>

            <label>Descripción de la falla</label>
            <textarea name="descripcion_falla" rows="3"><?= htmlspecialchars($dispositivo['descripcion_falla']) ?></textarea>

            <label>Imagen del dispositivo</label>
            <?php if (!empty($dispositivo['img_dispositivo'])): ?>
                <br>
                <img src="/ProyectoPandora/Public/img/imgDispositivos/<?= htmlspecialchars($dispositivo['img_dispositivo']) ?>">
                <br><br>
            <?php endif; ?>
            <input type="file" name="img_dispositivo" <?= empty($dispositivo['img_dispositivo']) ? 'required' : '' ?>>

            <button type="submit">Guardar</button>
        </form>
    </div>
</main>
<?php include_once __DIR__ . '/../Includes/Footer.php' ?>