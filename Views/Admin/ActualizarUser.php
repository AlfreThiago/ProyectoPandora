<?php include_once __DIR__ . '/../Includes/Header.php' ?>
<main>
    <div class="contenedor">
        <h2>Actualizar Usuario</h2>
        <form method="POST" action="">
            <input type="hidden" name="from" value="<?= $_GET['from'] ?? 'Admin/ListarUsers' ?>">
            <input type="hidden" name="id" value="<?= $user['id'] ?>">

            <label>Nombre</label>
            <input type="text" name="name" value="<?= $user['name'] ?>" required>

            <label>Rol</label>
            <select name="role" required>
                <option value="Cliente" <?= $user['role'] === 'Cliente' ? 'selected' : '' ?>>Cliente</option>
                <option value="Tecnico" <?= $user['role'] === 'Tecnico' ? 'selected' : '' ?>>Técnico</option>
                <option value="Supervisor" <?= $user['role'] === 'Supervisor' ? 'selected' : '' ?>>Supervisor</option>
                <option value="Administrador" <?= $user['role'] === 'Administrador' ? 'selected' : '' ?>>Administrador</option>
            </select>

            <button type="submit">Guardar</button>
        </form>

    </div>
</main>
<?php include_once __DIR__ . '/../Includes/Footer.php' ?>