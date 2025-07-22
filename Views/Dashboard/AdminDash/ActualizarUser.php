<body>
    <main>
        <div class="contenedor">
            <h2>Editar Usuario</h2>

           <!--Se editan los datos de un usuario-->
            <!-- Los datos se envían mediante POST a la ruta Edit-user con el ID del usuario -->
            <form action="/ProyectoPandora/Public/index.php?route=Admin/Edit-user&id=<?= htmlspecialchars($user['id']) ?>" method="POST">
                
             <!-- El usuario puede cambiar su nombre, que aparece cargado -->
                <label for="name">Nombre:</label>
                <input type="text" name="name" id="name" value="<?= htmlspecialchars($user['name']) ?>" required>
                
                <!-- Sirve para cambiar el rol del usuario o seleccionarlo-->
                <label for="role">Rol:</label>
                <select name="role" id="role" required>
                    <!-- Indica cuál es el rol que tiene actualmente el usuario -->
                    <option value="Administrador" <?= $user['role'] === 'Administrador' ? 'selected' : '' ?>>Administrador</option>
                    <option value="Supervisor" <?= $user['role'] === 'Supervisor' ? 'selected' : '' ?>>Supervisor</option>
                    <option value="Tecnico" <?= $user['role'] === 'Tecnico' ? 'selected' : '' ?>>Tecnico</option>
                    <option value="Cliente" <?= $user['role'] === 'Cliente' ? 'selected' : '' ?>>Cliente</option>
                </select>
                
                <!-- Botón para enviar los cambios y actualizar el usuario -->
                <button type="submit" name="update_user">Actualizar Usuario</button>
            </form>
        </div>
    </main>
</body>
