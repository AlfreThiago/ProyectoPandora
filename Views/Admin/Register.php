<?php include_once __DIR__ . '/../Includes/Sidebar.php'; ?>
<main>
    <?php
    if (isset($_GET['error']) && $_GET['error'] === 'EmailYaRegistrado'): ?>
        <div style="color: red; margin-bottom: 10px; text-align:center;">
            El correo electrónico ya está registrado. Por favor, usa otro.
        </div>
    <?php endif; ?>

    <div class="form-vertical-wrapper">
        <div class="form-vertical">
            <h3>Añadir Usuario</h3>

            <form action="/ProyectoPandora/Public/index.php?route=Register/RegisterAdmin" method="POST">
                
                <p>
                    <label for="name">Nombre:</label>
                    <input type="text" name="name" id="name" autocomplete="off" required>
                </p>

                <p>
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" autocomplete="off" required>
                </p>

                <p>
                    <label for="password">Contraseña:</label>
                    <input type="password" name="password" id="password" autocomplete="off" required>
                </p>

                <p>
                    <label for="role">Rol:</label>
                    <select name="role" id="role" required>
                        <option value="Administrador">Administrador</option>
                        <option value="Supervisor">Supervisor</option>
                        <option value="Tecnico">Técnico</option>
                        <option value="Cliente">Cliente</option>
                    </select>
                </p>

                <button type="submit">Registrar</button>
                <a href="/ProyectoPandora/Public/index.php?route=Default/Index" class="btn-volver">Volver</a>
            </form>
        </div>
    </div>
</main>
<?php include_once __DIR__ . '/../Includes/Footer.php'; ?>
