<main>
    <div class="contenedor">
        <h2>Actualizar Dispositivo</h2>

        <form method="POST" action="">
            <input type="hidden" name="id" value="<?= $categorias['id'] ?>">

            <label>Nombre</label>
            <input type="text" name="name" value="<?= htmlspecialchars($categorias['name']) ?>" required>

            <
            <button type="submit">Guardar</button>
        </form>
    </div>
</main>
