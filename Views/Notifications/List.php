<?php include_once __DIR__ . '/../Includes/Sidebar.php'; ?>
<main>
  <div class="panel">
    <div class="panel-header">
      <h2>Notificaciones</h2>
      <a class="btn" href="/ProyectoPandora/Public/index.php?route=Notification/Create">Nueva</a>
    </div>
    <div class="panel-body">
      <?php if (empty($list)): ?>
        <p>No hay notificaciones.</p>
      <?php else: ?>
        <ul class="notif-list">
          <?php foreach ($list as $n): ?>
            <li class="notif-item <?= $n['is_read'] ? 'read' : 'unread' ?>">
              <div class="notif-title"><?= htmlspecialchars($n['title']) ?></div>
              <div class="notif-body"><?= nl2br(htmlspecialchars($n['body'])) ?></div>
              <div class="notif-meta"><?= htmlspecialchars($n['created_at']) ?></div>
              <?php if (!$n['is_read']): ?>
                <form method="POST" action="/ProyectoPandora/Public/index.php?route=Notification/MarkRead" style="display:inline;">
                  <input type="hidden" name="id" value="<?= (int)$n['id'] ?>">
                  <button class="btn small" type="submit">Marcar como leída</button>
                </form>
              <?php endif; ?>
            </li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
    </div>
  </div>
</main>
