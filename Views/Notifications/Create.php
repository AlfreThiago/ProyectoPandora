<?php include_once __DIR__ . '/../Includes/Sidebar.php'; ?>
<main>
  <div class="panel">
    <div class="panel-header">
      <h2>Crear notificación</h2>
    </div>
    <div class="panel-body">
      <form method="POST" action="">
        <div class="perfil-campo">
          <label>Título</label>
          <input type="text" name="title" required>
        </div>
        <div class="perfil-campo">
          <label>Mensaje</label>
          <textarea name="body" rows="4" required></textarea>
        </div>
        <div class="perfil-campo">
          <label>Audiencia</label>
          <select name="audience" id="audienceSelect">
            <option value="ALL">Todos</option>
            <option value="ROLE">Por rol</option>
            <option value="USER">Usuario específico</option>
          </select>
        </div>
        <div class="perfil-campo" id="roleField" style="display:none;">
          <label>Rol</label>
          <select name="audience_role">
            <option value="Cliente">Cliente</option>
            <option value="Tecnico">Técnico</option>
            <option value="Supervisor">Supervisor</option>
            <option value="Administrador">Administrador</option>
          </select>
        </div>
        <div class="perfil-campo" id="userField" style="display:none;">
          <label>ID de usuario</label>
          <input type="number" name="target_user_id" min="1">
        </div>
        <button class="btn" type="submit">Publicar</button>
      </form>
    </div>
  </div>
</main>
<script>
  const sel = document.getElementById('audienceSelect');
  const roleF = document.getElementById('roleField');
  const userF = document.getElementById('userField');
  function upd(){
    const v = sel.value;
    roleF.style.display = (v==='ROLE')?'block':'none';
    userF.style.display = (v==='USER')?'block':'none';
  }
  sel.addEventListener('change', upd);
  upd();
</script>
