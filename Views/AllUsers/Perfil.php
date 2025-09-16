<?php include_once __DIR__ . '/../Includes/Sidebar.php'; ?>
<?php include_once __DIR__ . '/../Includes/Header.php'; ?>
<main>
    <div class="perfil-container">
        <div class="perfil-card">
            <div class="perfil-img">
                <form method="POST" action="" enctype="multipart/form-data">
                    <label for="img_perfil" class="img-label">
                        <img src="<?= htmlspecialchars($userImg) ?>" alt="Foto de perfil" class="img-perfil">
                        <span class="img-cambiar">Cambiar foto</span>
                    </label>
                    <input type="file" id="img_perfil" name="img_perfil" accept="image/*" style="display:none;">
                </form>
            </div>
            <div class="perfil-info">
                <form method="POST" action="">
                    <div class="perfil-campo">
                        <label for="name">Nombre:</label>
                        <input type="text" id="name" name="name" value="<?= htmlspecialchars($userName) ?>" required>
                    </div>
                    <div class="perfil-campo">
                        <label for="email">Correo:</label>
                        <input type="email" id="email" name="email" value="<?= htmlspecialchars($userEmail) ?>" required>
                    </div>
                    <div class="perfil-campo">
                        <label for="role">Rol:</label>
                        <input type="text" id="role" value="<?= htmlspecialchars($rol) ?>" readonly>
                    </div>
                    <button type="submit" class="btn-perfil-guardar">Guardar cambios</button>
                </form>
                <div class="perfil-stats">
                    <div class="stat-card">
                        <span class="stat-num"><?= $cantTickets ?></span>
                        <span class="stat-label">Tickets</span>
                    </div>
                    <?php if ($rol === 'Cliente' || $rol === 'Administrador' || $rol === 'Supervisor'): ?>
                    <div class="stat-card">
                        <span class="stat-num"><?= $cantDevices ?></span>
                        <span class="stat-label">Dispositivos</span>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="perfil-volver-panel">
        <a href="<?= $panelUrl ?>" class="btn-volver-panel">Volver a mi panel</a>
    </div>
</main>

<script>
document.querySelector('.img-label').addEventListener('click', function() {
    document.getElementById('img_perfil').click();
});
</script>

<?php include_once __DIR__ . '/../Includes/Footer.php'; ?>