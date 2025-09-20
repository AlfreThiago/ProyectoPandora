<?php include_once __DIR__ . '/../Includes/Sidebar.php'; ?>
<main>
    <div class="content">

        <div class="actualizar-wrapper animated bounceInUp">
            <h3>Actualizar Usuario</h3>

            <?php if (empty($user)): ?>
                <p>Usuario no encontrado.</p>
            <?php else: ?>
            <form method="POST" action="">
                <input type="hidden" name="from" value="<?= $_GET['from'] ?? 'Admin/ListarUsers' ?>">
                <input type="hidden" name="id" value="<?= $user['id'] ?? '' ?>">

                <label>Nombre</label>
                <input type="text" name="name" value="<?= $user['name'] ?? '' ?>" required>

                <label>Rol</label>
                <select name="role" required>
                    <option value="Cliente" <?= ($user['role'] ?? '') === 'Cliente' ? 'selected' : '' ?>>Cliente</option>
                    <option value="Tecnico" <?= ($user['role'] ?? '') === 'Tecnico' ? 'selected' : '' ?>>Técnico</option>
                    <option value="Supervisor" <?= ($user['role'] ?? '') === 'Supervisor' ? 'selected' : '' ?>>Supervisor</option>
                    <option value="Administrador" <?= ($user['role'] ?? '') === 'Administrador' ? 'selected' : '' ?>>Administrador</option>
                </select>

                <button type="submit">Guardar</button>
            </form>
            <a href="/ProyectoPandora/Public/index.php?route=Admin/ListarUsers" class="btn-volver">Volver a la lista de Usuarios</a>
            <?php endif; ?>
        </div>

    </div>
</main>
<?php include_once __DIR__ . '/../Includes/Footer.php'; ?>
