<?php
if (session_status() === PHP_SESSION_NONE) {
		session_start();
}
$user = $_SESSION['user'] ?? null;
$rol = $user['role'] ?? '';
$name = $user['name'] ?? '';
$email = $user['email'] ?? '';
$avatar = $user['img_perfil'] ?? '';
// Normalizar: si no viene ruta válida, usar default de imgPerfil
$defaultAvatar = '/ProyectoPandora/Public/img/imgPerfil/default.png';
$fallbackAvatar = '/ProyectoPandora/Public/img/Innovasys.png';
// Si avatar es relativo a imgPerfil (solo nombre)
if ($avatar && strpos($avatar, '/ProyectoPandora/') !== 0) {
	$avatar = '/ProyectoPandora/Public/img/imgPerfil/' . ltrim($avatar, '/');
}
// Validar existencia en disco; si no existe, usar default y si tampoco existe, usar fallback
$avatarFs = rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . $avatar;
if (!$avatar || !is_file($avatarFs)) {
	$avatar = $defaultAvatar;
	$defaultFs = rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . $defaultAvatar;
	if (!is_file($defaultFs)) {
		$avatar = $fallbackAvatar;
	}
}

// Detectar ruta actual
$route = $_GET['route'] ?? '';

function headerMeta(string $route, string $rol): array {
	// Default
	$title = 'Panel';
	$subtitle = '';
	switch (true) {
		// Rutas finales preferidas
		case stripos($route, 'Admin/ListarUsers') === 0:
			$title = 'Usuarios';
			$subtitle = 'Administración de cuentas';
			break;
		case stripos($route, 'Supervisor/Asignar') === 0:
			$title = 'Asignar Técnicos a Tickets';
			$subtitle = 'Gestiona la asignación de técnicos a los tickets pendientes';
			break;
		case stripos($route, 'Supervisor/GestionInventario') === 0:
			$title = 'Gestión de Inventario';
			$subtitle = 'Administra items, stock y categorías';
			break;
		case stripos($route, 'Tecnico/MisReparaciones') === 0:
			$title = 'Mis Reparaciones';
			$subtitle = 'Trabajos en curso y pendientes';
			break;
		case stripos($route, 'Tecnico/MisRepuestos') === 0:
			$title = 'Mis Repuestos';
			$subtitle = 'Solicitud de ítems para tickets asignados';
			break;
		case stripos($route, 'Cliente/MisDevice') === 0:
			$title = 'Mis Dispositivos';
			$subtitle = 'Tus dispositivos y tickets';
			break;
		case stripos($route, 'Cliente/MisTicket') === 0:
			$title = 'Mis Tickets';
			$subtitle = 'Seguimiento de tus solicitudes';
			break;
		case stripos($route, 'Ticket/') === 0:
			$title = 'Tickets';
			$subtitle = 'Listado y seguimiento de tickets';
			break;
		case stripos($route, 'Inventario') === 0:
			$title = 'Inventario';
			$subtitle = 'Consulta y administración del inventario';
			break;
		case stripos($route, 'Device') === 0:
			$title = 'Dispositivos';
			$subtitle = 'Gestión de dispositivos y categorías';
			break;
		// Compatibilidad con rutas antiguas de paneles
		case stripos($route, 'Admin/PanelAdmin') === 0:
			$title = 'Usuarios';
			$subtitle = 'Administración de cuentas';
			break;
		case stripos($route, 'Tecnico/PanelTecnico') === 0:
			$title = 'Mis Reparaciones';
			$subtitle = 'Tickets asignados y progreso';
			break;
		case stripos($route, 'Cliente/PanelCliente') === 0:
			$title = 'Mis Dispositivos';
			$subtitle = 'Tus dispositivos y tickets';
			break;
		case stripos($route, 'EstadoTicket/ListarEstados') === 0:
			$title = 'Estados de Tickets';
			$subtitle = 'Gestión de estados disponibles';
			break;
		default:
			$title = 'Home Portal';
			$subtitle = 'Bienvenido al sistema';
	}
	if ($rol) $subtitle .= ($subtitle ? ' · ' : '') . 'Rol: ' . $rol;
	return [$title, $subtitle];
}

list($title, $subtitle) = headerMeta($route, $rol);
?>

<header class="header">
	<h1 class="header-title"><?= htmlspecialchars($title) ?></h1>
	<?php if ($subtitle): ?>
	<p class="header-subtitle"><?= htmlspecialchars($subtitle) ?></p>
	<?php endif; ?>
	<div class="header-actions">
		<span class="icon-btn"><i class='bx bx-chat'></i></span>
		<li class="profile-menu">
			<a href="javascript:void(0)" id="btn-profile">
				<img src="<?= htmlspecialchars($avatar) ?>" alt="Perfil" class="user-avatar">
			</a>
			<div id="submenu-profile" class="submenu">
				<div class="submenu-header">
					<img src="<?= htmlspecialchars($avatar) ?>" alt="Perfil" class="user-avatar">
					<p class="user-name">¡Hola, <?= htmlspecialchars($name) ?>!</p>
					<small class="user-email"><?= htmlspecialchars($email) ?></small>
				</div>
				<hr>
				<ul>
					<li>
						<a href="/ProyectoPandora/Public/index.php?route=Default/Perfil">
							<i class='bx bx-user'></i>
							<span>Perfil</span>
						</a>
					</li>
					<li>
						<a href="/ProyectoPandora/Public/index.php?route=Default/Guia">
							<i class='bx bx-help-circle'></i>
							<span>Guía</span>
						</a>
					</li>
					<li>
						<a href="#">
							<i class='bx bx-bell-minus'></i>
							<span>Notificaciones</span>
						</a>
					</li>
					<li>
						<a href="/ProyectoPandora/Public/index.php?route=Default/Index">
							<i class='bx bx-home'></i>
							<span>Inicio</span>
						</a>
					</li>
				</ul>
				<hr>
				<div class="submenu-footer">
					<a href="/ProyectoPandora/Public/index.php?route=Auth/Logout" class="logout">
						<i class='bx bx-log-out'></i> Cerrar sesión
					</a>
				</div>
			</div>
		</li>
	</div>
</header>
<script src="/ProyectoPandora/Public/js/modal.js"></script>