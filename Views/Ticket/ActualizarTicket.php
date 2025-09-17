<?php include_once __DIR__ . '/../Includes/Sidebar.php'; ?>
<main>
    <div class="Contenedor">
        <section class="Conenedor-formulario-principal">
        <h2 id="tituloEdicion">Editar Ticket</h2>
            <div class="Formulario-general">
                <div class="Formulario-contenedor">
                    <form id="formActualizar" method="POST" action="/ProyectoPandora/Public/index.php?route=Ticket/Actualizar">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($ticket['id'] ?? '') ?>">

                            <!-- Descripción editable por todos -->
                            <div class="mb-3">
                                <p>
                                    <label class="form-label">Descripción de la falla</label>
                                    <textarea name="descripcion_falla" id="descripcionFalla" class="form-control" rows="3" required><?= htmlspecialchars($ticket['descripcion_falla'] ?? $ticket['descripcion'] ?? '') ?></textarea>
                                </p>
                            </div>

                        <!-- Si es cliente, puede actualizar datos del dispositivo -->
                        <?php if ($rol === 'Cliente'): ?>
                        <div class="mb-3">
                            <p>
                                <label class="form-label">Marca del dispositivo</label>
                                <input type="text" name="marca" class="form-control" value="<?= htmlspecialchars($ticket['marca'] ?? '') ?>" required>
                            </p>
                        </div>
                        <div class="mb-3">
                            <p>
                                
                                <label class="form-label">Modelo del dispositivo</label>
                                <input type="text" name="modelo" class="form-control" value="<?= htmlspecialchars($ticket['modelo'] ?? '') ?>" required>
                            </p>
                        </div>
                        <?php endif; ?>

                        <!-- Estado editable por Técnico, Supervisor y Administrador -->
                        <?php if (in_array($rol, ['Tecnico', 'Supervisor', 'Administrador'])): ?>
                        <div class="mb-3">
                            <p>
                                <label class="form-label">Estado del ticket</label>
                                <select name="estado_id" class="form-control" required>
                                    <?php foreach ($estados as $estado): ?>
                                        <option value="<?= $estado['id'] ?>" <?= ($estado['id'] == ($ticket['estado_id'] ?? '')) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($estado['name'] ?? '') ?>
                                        </option>
                                        <?php endforeach; ?>
                                </select>
                            </p>
                        </div>
                        <?php endif; ?>

                        <!-- Asignar técnico solo para Supervisor y Administrador -->
                        <?php if (in_array($rol, ['Supervisor', 'Administrador'])): ?>
                        <div class="mb-3">
                            <p>
                                <label class="form-label">Asignar Técnico</label>
                                <select name="tecnico_id" class="form-control">
                                    <option value="">-- Sin asignar --</option>
                                    <?php foreach ($tecnicos as $tecnico): ?>
                                        <option value="<?= $tecnico['id'] ?>" <?= ($tecnico['id'] == ($ticket['tecnico_id'] ?? '')) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($tecnico['name'] ?? '') ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                            </p>
                    </div>
                        <?php endif; ?>

                            <p>
                                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                            </p>
                            <p>
                                <a href="<?= $_SESSION['prev_url'] ?? '/ProyectoPandora/Public/index.php?route=Default/Index' ?>" class="btn btn-secondary">Volver</a>
                            </p>
                    </form>
                </div>
            </div>
        </section>
    </div>
</main>
<?php include_once __DIR__ . '/../Includes/Footer.php' ?>