<?php include_once __DIR__ . '/../Includes/Sidebar.php'; ?>
<main>
  <div class="perfil-wrapper">
    <!-- HEADER -->
    <div class="perfil-header">
      <form method="POST" action="" enctype="multipart/form-data">
        <label for="avatarUpload" title="Cambiar foto de perfil">
          <img src="<?= htmlspecialchars($userImg) ?>" class="perfil-avatar" alt="Foto de perfil">
        </label>
        <input type="file" id="avatarUpload" name="avatar" accept="image/*" style="display: none;" onchange="this.form.submit()">
      </form>
      <h2><?= htmlspecialchars($userName) ?></h2>
      <p><?= htmlspecialchars($rol) ?></p>
    </div>

    <!-- TABS -->
    <div class="perfil-tabs">
      <button class="tab active" data-tab="info">Perfil</button>
      <button class="tab" data-tab="ajustes">Ajustes</button>
    </div>

    <!-- PERFIL -->
    <div class="perfil-content active" id="info">
      <!-- ... campos ... -->
       <form method="POST" action="">
        <div class="perfil-campo">
          <label>Nombre:</label>
          <input type="text" name="name" value="<?= htmlspecialchars($userName) ?>">
        </div>

        <div class="perfil-campo">
          <label>Correo:</label>
          <input type="email" name="email" value="<?= htmlspecialchars($userEmail) ?>">
        </div>

        <div class="perfil-campo">
          <label>Rol:</label>
          <input type="text" value="<?= htmlspecialchars($rol) ?>" readonly>
        </div>

        <?php if ($rol === 'Tecnico'): ?>
          <div class="perfil-campo">
            <label>Especialidad:</label>
            <input type="text" name="especialidad" value="<?= htmlspecialchars($tecnicoEspecialidad ?? '') ?>" placeholder="Ej: Electrónica, Microsoldadura, Software..." />
          </div>
        <?php endif; ?>

        <button type="submit" class="btn-perfil-guardar">Guardar cambios</button>
      </form>
    </div>

    <!-- AJUSTES -->
    <div class="perfil-content" id="ajustes">
      <?php if ($rol === 'Tecnico'): ?>
      <form method="POST" action="">
        <div class="perfil-campo">
          <label>Disponibilidad:</label>
          <?php $dispActual = $tecnicoDisponibilidad ?? 'Disponible'; ?>
          <select name="disponibilidad">
            <option value="Disponible" <?= ($dispActual === 'Disponible') ? 'selected' : '' ?>>Disponible</option>
            <option value="Ocupado" <?= ($dispActual === 'Ocupado') ? 'selected' : '' ?>>No disponible</option>
          </select>
        </div>
        <button type="submit" class="btn-perfil-guardar">Guardar ajustes</button>
      </form>
      <?php endif; ?>

      <!-- TOGGLE GLOBAL -->
      <div class="perfil-campo modo-oscuro-toggle">
        <label for="toggle-darkmode">🌙 Modo Claro/Oscuro:</label>
        <label class="switch">
          <input type="checkbox" id="toggle-darkmode">
          <span class="slider"></span>
        </label>
      </div>
    </div>

    <div class="perfil-volver-panel">
      <a href="/ProyectoPandora/Public/index.php?route=Default/Index" class="btn-volver-panel">
        <i class="bx bx-arrow-back"></i> Volver
      </a>
    </div>
  </div>
</main>

<!-- Script de tabs -->
<script>
  document.querySelectorAll('.perfil-tabs .tab').forEach(tab => {
    tab.addEventListener('click', () => {
      document.querySelectorAll('.perfil-tabs .tab').forEach(t => t.classList.remove('active'));
      document.querySelectorAll('.perfil-content').forEach(c => c.classList.remove('active'));
      tab.classList.add('active');
      document.getElementById(tab.dataset.tab).classList.add('active');
    });
  });
</script>
