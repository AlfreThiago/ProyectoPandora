<?php include_once __DIR__ . '/../Includes/Sidebar.php' ?>
<main>
    <div class="Contenedor">
        <section class="Conenedor-formulario-principal">
            <h2>Actualizar Usuario</h2>
            <div class="Formulario-general">
                <div class="Formulario-contenedor">
                    <form method="POST" action="">
                        <p>
                            <input type="hidden" name="from" value="<?= $_GET['from'] ?? 'Admin/ListarUsers' ?>">
                            <input type="hidden" name="id" value="<?= $user['id'] ?>">
                        </p>
                        <p>
                            <label>Nombre</label>
                            <input type="text" name="name" value="<?= $user['name'] ?>" required>
                        </p>
                        <p>
                            <label>Rol</label>
                            <select name="role" required>
                                <option value="Cliente" <?= $user['role'] === 'Cliente' ? 'selected' : '' ?>>Cliente</option>
                                <option value="Tecnico" <?= $user['role'] === 'Tecnico' ? 'selected' : '' ?>>Técnico</option>
                                <option value="Supervisor" <?= $user['role'] === 'Supervisor' ? 'selected' : '' ?>>Supervisor</option>
                                <option value="Administrador" <?= $user['role'] === 'Administrador' ? 'selected' : '' ?>>Administrador</option>
                            </select>
                        </p>
                        <p>
                            <button type="submit">Guardar</button>
                        </p>
                    </form>
                </div>
            </div>
        </section>

    </div>
</main>
<?php include_once __DIR__ . '/../Includes/Footer.php' ?>