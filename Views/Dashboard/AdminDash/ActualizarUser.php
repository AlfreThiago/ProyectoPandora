<body>
    <main>
        <div class="contenedor">
            <h2>Editar Usuario</h2>

            <form action="/ProyectoPandora/Public/index.php?route=Admin/Edit-user&id=<?= htmlspecialchars($user['id']) ?>" method="POST">
                <label for="name">Nombre:</label>
                <input type="text" name="name" id="name" value="<?= htmlspecialchars($user['name']) ?>" required>
                <label for="role">Rol:</label>
                <select name="role" id="role" required>
                    <option value="Administrador" <?= $user['role'] === 'Administrador' ? 'selected' : '' ?>>Administrador
                    </option>
                    <option value="Supervisor" <?= $user['role'] === 'Supervisor' ? 'selected' : '' ?>>Supervisor
                    </option>
                    <option value="Tecnico" <?= $user['role'] === 'Tecnico' ? 'selected' : '' ?>>Tecnico
                    </option>
                    <option value="Cliente" <?= $user['role'] === 'Cliente' ? 'selected' : '' ?>>Cliente
                    </option>
                </select>
                <button type="submit" name="update_user">Actualizar Usuario</button>
            </form>
        </div>
    </main>
</body>