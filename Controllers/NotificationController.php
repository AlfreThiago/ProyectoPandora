<?php
require_once __DIR__ . '/../Core/Auth.php';
require_once __DIR__ . '/../Core/Database.php';
require_once __DIR__ . '/../Models/Notification.php';

class NotificationController
{
    public function Index()
    {
        Auth::check();
        $user = Auth::user();
        // Auto-refresh de la página cada 10s para ver nuevas notificaciones
        header('Refresh: 10');
        $db = new Database(); $db->connectDatabase();
        $model = new NotificationModel($db->getConnection());

        $page = max(1, (int)($_GET['page'] ?? 1));
        $per = 20; $off = ($page-1)*$per;
        $list = $model->listForUser((int)$user['id'], (string)$user['role'], $per, $off);

        include_once __DIR__ . '/../Views/Notifications/List.php';
    }

    // Endpoint ligero para el badge: devuelve el conteo sin recargar todo
    public function Count()
    {
        Auth::check();
        $user = Auth::user();
        $db = new Database(); $db->connectDatabase();
        $model = new NotificationModel($db->getConnection());
        $count = $model->countUnread((int)$user['id'], (string)$user['role']);
        header('Content-Type: text/plain; charset=utf-8');
        header('Cache-Control: no-store, no-cache, must-revalidate');
        echo (int)$count;
        exit;
    }

    public function MarkRead()
    {
        Auth::check();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /ProyectoPandora/Public/index.php?route=Notification/Index'); exit;
        }
        $user = Auth::user();
        $id = (int)($_POST['id'] ?? 0);
        $db = new Database(); $db->connectDatabase();
        $model = new NotificationModel($db->getConnection());
        if ($id) { $model->markRead((int)$user['id'], $id); }
        header('Location: /ProyectoPandora/Public/index.php?route=Notification/Index');
        exit;
    }

    public function Create()
    {
        Auth::checkRole(['Administrador','Supervisor']);
        $user = Auth::user();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim((string)($_POST['title'] ?? ''));
            $body = trim((string)($_POST['body'] ?? ''));
            $aud = $_POST['audience'] ?? 'ALL';
            $role = $_POST['audience_role'] ?? null;
            $target = isset($_POST['target_user_id']) && $_POST['target_user_id'] !== '' ? (int)$_POST['target_user_id'] : null;
            $db = new Database(); $db->connectDatabase();
            $model = new NotificationModel($db->getConnection());
            $model->create($title, $body, $aud, $role, $target, (int)$user['id']);
            header('Location: /ProyectoPandora/Public/index.php?route=Notification/Index');
            exit;
        }
        include_once __DIR__ . '/../Views/Notifications/Create.php';
    }
}
