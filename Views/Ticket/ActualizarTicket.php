<?php include_once __DIR__ . '/../Includes/Sidebar.php'; ?>
<main>
    <div class="content">

        <div class="contact-wrapper animated bounceInUp">
            <div class="contact-form">
                <h3>Editar Ticket</h3>

                <form id="formActualizar" method="POST" action="/ProyectoPandora/Public/index.php?route=Ticket/Actualizar">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($ticket['id'] ?? '') ?>">

                    <!-- Descripción editable por todos -->
                    <p class="block">
                        <label for="descripcionFalla">Descripción de la falla</label>
                        <textarea name="descripcion_falla" id="descripcionFalla" rows="3" required><?= htmlspecialchars($ticket['descripcion_falla'] ?? $ticket['descripcion'] ?? '') ?></textarea>
                    </p>

                    <!-- Si es cliente, puede actualizar datos del dispositivo -->
                    <?php if ($rol === 'Cliente'): ?>
                        <p>
                            <label for="marca">Marca del dispositivo</label>
                            <input type="text" id="marca" name="marca" value="<?= htmlspecialchars($ticket['marca'] ?? '') ?>" required>
                        </p>

                        <p>
                            <label for="modelo">Modelo del dispositivo</label>
                            <input type="text" id="modelo" name="modelo" value="<?= htmlspecialchars($ticket['modelo'] ?? '') ?>" required>
                        </p>
                    <?php endif; ?>

                    <!-- Estado editable por Técnico, Supervisor y Administrador -->
                    <?php if (in_array($rol, ['Tecnico', 'Supervisor', 'Administrador'])): ?>
                        <p>
                            <label for="estado_id">Estado del ticket</label>
                            <select id="estado_id" name="estado_id" required>
                                <?php foreach ($estados as $estado): ?>
                                    <option value="<?= $estado['id'] ?>" <?= ($estado['id'] == ($ticket['estado_id'] ?? '')) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($estado['name'] ?? '') ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </p>
                    <?php endif; ?>

                        <!-- Asignar técnico solo para Supervisor -->
                        <?php if (in_array($rol, ['Supervisor'])): ?>
                        <p>
                            <label for="tecnico_id">Asignar Técnico</label>
                            <select id="tecnico_id" name="tecnico_id">
                                <option value="">-- Sin asignar --</option>
                                <?php foreach ($tecnicos as $tecnico): ?>
                                    <option value="<?= $tecnico['id'] ?>" <?= ($tecnico['id'] == ($ticket['tecnico_id'] ?? '')) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($tecnico['name'] ?? '') ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </p>
                    <?php endif; ?>

                    <p class="block">
                        <button type="submit">Guardar Cambios</button>
                    </p>
                </form>

                <a href="<?= $_SESSION['prev_url'] ?? '/ProyectoPandora/Public/index.php?route=Default/Index' ?>" class="btn-volver">Volver</a>
            </div>
        </div>

    </div>
</main>

<?php include_once __DIR__ . '/../Includes/Footer.php'; ?>
