<?php include_once __DIR__ . '/../Includes/Sidebar.php' ?>

<main>
    <div class="Contenedor">
        <section class="Conenedor-formulario-principal">
            <h2>Crear nuevo Ticket</h2>
            <div class="Formulario-general">
                <div class="Formulario-contenedor">
                    <?php if (isset($_GET['error'])): ?>
                    <div style="color: red; font-weight: bold; margin-bottom: 15px;">
                        <?= htmlspecialchars($_GET['error']) ?>
                    </div>
                    <?php endif; ?>
                    <form method="POST" action="/ProyectoPandora/Public/index.php?route=Ticket/Crear">
                        <p>
                            <input type="hidden" name="recarga_cliente" value="1">
                            <?php if (isset($isAdmin) && $isAdmin && isset($clientes)): ?>
                                <label for="cliente_id">Seleccione un cliente:</label><br>
                                <select id="cliente_id" name="cliente_id" required onchange="this.form.submit()">
                                    <option value="">-- Seleccionar --</option>
                                    <?php foreach ($clientes as $cliente): ?>
                                        <option value="<?= $cliente['id'] ?>" <?= (isset($_POST['cliente_id']) && $_POST['cliente_id'] == $cliente['id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($cliente['name']) ?> (<?= htmlspecialchars($cliente['email']) ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select><br><br>
                            <?php endif; ?>
                        </p>

                        <p>
                            <label for="dispositivo">Seleccione un dispositivo:</label><br>
                            <select id="dispositivo" name="dispositivo_id" required <?= empty($data) ? 'disabled' : '' ?>>
                                <option value="">-- Seleccionar --</option>
                                <?php foreach ($data as $dispositivo): ?>
                                    <option value="<?= $dispositivo['id'] ?>">
                                        <?= htmlspecialchars($dispositivo['marca'] . ' ' . $dispositivo['modelo']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select><br><br>
                        </p>
                        <p>
                            <label for="descripcion">Descripción de la falla:</label><br>
                            <textarea id="descripcion" name="descripcion" rows="5" required></textarea><br><br>
                        </p>
                        <p>
                            <button type="submit" onclick="document.getElementsByName('recarga_cliente')[0].value=''">Crear Ticket</button>
                        </p>
                        <p>
                            <a href="/ProyectoPandora/Public/index.php?route=Ticket/Listar" class="btn-form-categoria">Cancelar</a>
                        </p>
                    </form>
                </div>
            </div>
        </section>
    </div>
</main>

<script>
    function mostrarDescripcion(select) {
        let descripcion = select.options[select.selectedIndex].getAttribute('data-descripcion');
        document.getElementById('descripcion').value = descripcion || "";
    }
</script>
<?php include_once __DIR__ . '/../Includes/Footer.php' ?>