<?php include_once __DIR__ . '/../Includes/Sidebar.php'; ?>
<main>
    <div class="Contenedor">
        <section class="Conenedor-formulario-principal">
            <h2>Agregar Dispositivo</h2>
            <div class="Formulario-general">
                <div class="Formulario-contenedor">
                    <form action="/ProyectoPandora/Public/index.php?route=Device/CrearDispositivo" method="POST" enctype="multipart/form-data">
                        <?php if (isset($isAdmin) && $isAdmin && isset($clientes)): ?>
                            <p>
                                <label for="user_id">Cliente:</label>
                                <select id="user_id" name="user_id" required>
                                    <option value="">-- Seleccionar --</option>
                                    <?php foreach ($clientes as $cliente): ?>
                                        <option value="<?= $cliente['id'] ?>">
                                            <?= htmlspecialchars($cliente['name']) ?> (<?= htmlspecialchars($cliente['email']) ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </p>
                        <?php endif; ?>
                        <p>
                            <label for="categoria_id">Categoría del Dispositivo:</label>
                            <select id="categoria_id" name="categoria_id" required>
                                <option value="">-- Seleccionar --</option>
                                <?php if (isset($categorias) && is_array($categorias)): ?>
                                    <?php foreach ($categorias as $categoria): ?>
                                        <option value="<?= $categoria['id'] ?>">
                                            <?= htmlspecialchars($categoria['nombre'] ?? $categoria['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </p>
                        <p>
                            <label for="marca">Marca:</label>
                            <input type="text" id="marca" name="marca" required>
                        </p>
                        <p>
                            <label for="modelo">Modelo:</label>
                            <input type="text" id="modelo" name="modelo" required>
                        </p>
                        <p>
                            <label for="descripcion_falla">Descripción de Falla:</label>
                            <input type="text" id="descripcion_falla" name="descripcion_falla" required>
                        </p>
                        <p>
                            <label for="img_dispositivo">Imagen del Dispositivo:</label>
                            <input type="file" id="img_dispositivo" name="img_dispositivo" accept="image/*" required>
                        </p>
                        <p>
                            <button type="submit">Agregar Dispositivo</button>
                        </p>
                    </form>
                    <?php
                    $user = $_SESSION['user'] ?? null;
                    $rol = $user['role'] ?? '';
                    if ($rol === 'Administrador') {
                        $volverUrl = "/ProyectoPandora/Public/index.php?route=Device/ListarDevice";
                    } elseif ($rol === 'Cliente') {
                        $volverUrl = "/ProyectoPandora/Public/index.php?route=Cliente/MisDevice";
                    } else {
                        $volverUrl = "/ProyectoPandora/Public/index.php?route=Default/Index";
                    }
                    ?>
                    <a href="<?= $volverUrl ?>" class="btn btn-secondary">Volver</a>
                </div>
            </div>
        </section>
    </div>
</main>
<?php include_once __DIR__ . '/../Includes/Footer.php' ?>