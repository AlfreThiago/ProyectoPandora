<main>
    <div class="contenedor">
        <h2>Actualizar Dispositivo</h2>

        <form method="POST" action="">
            <input type="hidden" name="id" value="<?= $device['id'] ?>">

            <label>Categoría</label>
            <select name="categoria_id" required>
                <option value="">Seleccione una categoría</option>
                <?php foreach ($categorias as $categoria): ?>
                    <option value="<?= $categoria['id'] ?>" 
                        <?= ($device['categoria_id'] == $categoria['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($categoria['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label>Marca</label>
            <input type="text" name="marca" value="<?= htmlspecialchars($device['marca']) ?>" required>

            <label>Modelo</label>
            <input type="text" name="modelo" value="<?= htmlspecialchars($device['modelo']) ?>" required>

            <label>Descripción de la falla</label>
            <textarea name="descripcion_falla" rows="3"><?= htmlspecialchars($device['descripcion_falla']) ?></textarea>

            <label>Imagen del dispositivo</label>
            <?php if (!empty($device['img_dispositivo'])): ?>
                <br>
                <img src="Public/img/imgDispositivos/<?= htmlspecialchars($device['img_dispositivo']) ?>" alt="Imagen actual" width="150">
                <br><br>
            <?php endif; ?>
            <input type="file" name="img_dispositivo" <?= empty($device['img_dispositivo']) ? 'required' : '' ?>>

            <button type="submit">Guardar</button>
        </form>
    </div>
</main>
