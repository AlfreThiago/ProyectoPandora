<?php include_once __DIR__ . '/../Includes/Sidebar.php' ?>

<main>
    <div class="contenedor">
        <h1>Crear nuevo Ticket</h1>
        <?php if (isset($_GET['error'])): ?>
            <div style="color: red; font-weight: bold; margin-bottom: 15px;">
                <?= htmlspecialchars($_GET['error']) ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="/ProyectoPandora/Public/index.php?route=Ticket/Crear">
            <?php if (isset($isAdmin) && $isAdmin && isset($clientes)): ?>
                <label for="cliente_id">Seleccione un cliente:</label><br>
                <select id="cliente_id" name="cliente_id" required>
                    <option value="">-- Seleccionar --</option>
                    <?php foreach ($clientes as $cliente): ?>
                        <option value="<?= $cliente['id'] ?>">
                            <?= htmlspecialchars($cliente['name']) ?> (<?= htmlspecialchars($cliente['email']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select><br><br>
            <?php endif; ?>

            <label for="dispositivo">Seleccione un dispositivo:</label><br>
            <select id="dispositivo" name="dispositivo_id" required onchange="mostrarDescripcion(this)">
                <option value="">-- Seleccionar --</option>
                <?php foreach ($data as $dispositivo): ?>
                    <option value="<?= $dispositivo['id'] ?>"
                        data-descripcion="<?= htmlspecialchars($dispositivo['descripcion_falla']) ?>">
                        <?= $dispositivo['marca'] . " " . $dispositivo['modelo'] ?>
                    </option>
                <?php endforeach; ?>
            </select><br><br>

            <label for="descripcion">Descripción de la falla:</label><br>
            <textarea id="descripcion" name="descripcion" rows="5" required></textarea><br><br>

            <button type="submit">Crear</button>
            <a href="/ProyectoPandora/Public/index.php?route=Ticket/Listar">Cancelar</a>
        </form>
    </div>
</main>

<script>
    function mostrarDescripcion(select) {
        let descripcion = select.options[select.selectedIndex].getAttribute('data-descripcion');
        document.getElementById('descripcion').value = descripcion || "";
    }
</script>
<?php include_once __DIR__ . '/../Includes/Footer.php' ?>