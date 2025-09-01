<?php include_once __DIR__ . '/../Includes/Sidebar.php' ?>
<main>
    <div class="contenedor">
        <h1>Crear nuevo Ticket</h1>
        <form method="POST" action="/ProyectoPandora/Public/index.php?route=Ticket/Crear">

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