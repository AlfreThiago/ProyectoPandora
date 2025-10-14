<?php
require_once __DIR__ . '/../../Core/Auth.php';
$authUser = Auth::user();
$rol = $authUser['role'] ?? '';
$name = $authUser['name'] ?? '';
$email = $authUser['email'] ?? '';
$avatar = $authUser['img_perfil'] ?? '';

$defaultAvatar = '/ProyectoPandora/Public/img/imgPerfil/default.png';
$fallbackAvatar = '/ProyectoPandora/Public/img/Innovasys.png';

if ($avatar && strpos($avatar, '/ProyectoPandora/') !== 0) {
	$avatar = '/ProyectoPandora/Public/img/imgPerfil/' . ltrim($avatar, '/');
}

$avatarFs = rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . $avatar;
if (!$avatar || !is_file($avatarFs)) {
	$avatar = $defaultAvatar;
	$defaultFs = rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . $defaultAvatar;
	if (!is_file($defaultFs)) {
		$avatar = $fallbackAvatar;
	}
}


// Ruta actual (por si se requiere algún ajuste puntual)
$route = $_GET['route'] ?? '';
// ¿Es la Home?
function isHomeRoute(string $route): bool {
	if ($route === '' || strtolower($route) === 'default/index') return true;
	return false;
}
// Meta dinámica por ruta (título/subtítulo)
function headerMeta(string $route, string $rol): array {
	$title = 'Home Portal';
	$subtitle = 'Bienvenido al sistema';
	switch (true) {
		case stripos($route, 'Default/Index') === 0:
			$title = 'Home'; $subtitle = 'Resumen y accesos rápidos'; break;
		case stripos($route, 'EstadoTicket/') === 0:
			$title = 'Estados de tickets'; $subtitle = 'Definiciones, flujos y transiciones'; break;
		case stripos($route, 'Historial/') === 0:
			$title = 'Historial del sistema'; $subtitle = 'Acciones registradas y filtros'; break;
		case stripos($route, 'Admin/') === 0:
			$title = 'Administración'; $subtitle = 'Gestión de usuarios y ajustes'; break;
		case stripos($route, 'Supervisor/Asignar') === 0:
			$title = 'Asignación de técnicos'; $subtitle = 'Tickets pendientes y carga de trabajo'; break;
		case stripos($route, 'Supervisor/Presupuestos') === 0:
			$title = 'Presupuestos'; $subtitle = 'Repuestos, mano de obra y aprobaciones'; break;
		case stripos($route, 'Supervisor/GestionInventario') === 0:
			$title = 'Inventario'; $subtitle = 'Ítems, stock y categorías'; break;
		case stripos($route, 'Tecnico/MisRepuestos') === 0:
			$title = 'Mis repuestos'; $subtitle = 'Solicitudes, consumos y stock asignado'; break;
		case stripos($route, 'Tecnico/MisReparaciones') === 0:
			$title = 'Mis reparaciones'; $subtitle = 'Trabajos en curso y pendientes'; break;
		case stripos($route, 'Tecnico/MisStats') === 0:
			$title = 'Mis estadísticas'; $subtitle = 'Rendimiento y métricas'; break;
		case stripos($route, 'Cliente/MisDevice') === 0:
			$title = 'Mis dispositivos'; $subtitle = 'Equipos registrados y tickets'; break;
		case stripos($route, 'Cliente/MisTicket') === 0:
			$title = 'Mis tickets'; $subtitle = 'Seguimiento y estado'; break;
		case stripos($route, 'Ticket/') === 0:
			$title = 'Tickets'; $subtitle = 'Listado y gestión'; break;
		case stripos($route, 'Inventario/') === 0:
			$title = 'Inventario'; $subtitle = 'Consulta y administración'; break;
		case stripos($route, 'Device/') === 0:
			$title = 'Dispositivos'; $subtitle = 'Gestión y categorías'; break;
		case stripos($route, 'Default/Guia') === 0:
			$title = 'Guía de uso'; $subtitle = 'Cómo utilizar Innovasys'; break;
	}
	return [$title, $subtitle];
}

list($title, $subtitle) = headerMeta($route, $rol);
?>
<!-- Estilos del header consolidados en AdminDash.css -->

<header class="header hero-header">
	<div class="hero-row">
		<div class="hero-left">
			<?php if (isHomeRoute($route)): ?>
				<p class="hero-greet">
					<?= $authUser ? '¡Hola, '.htmlspecialchars($name).'!' : 'Bienvenido a Innovasys'; ?>
				</p>
			<?php endif; ?>
			<p class="hero-sub">
				<?= htmlspecialchars($title) ?> · <?= htmlspecialchars($subtitle) ?>
			</p>
		</div>
		<div class="hero-actions">
			<?php if (stripos($route, 'Cliente/MisTicket') === 0 || stripos($route, 'Cliente/MisTicketActivo') === 0 || stripos($route, 'Cliente/MisTicketTerminados') === 0): ?>
				<a href="/ProyectoPandora/Public/index.php?route=Cliente/MisTicketActivo" class="btn btn-outline small" title="Ver activos">Activos</a>
				<a href="/ProyectoPandora/Public/index.php?route=Cliente/MisTicketTerminados" class="btn btn-outline small" title="Ver finalizados">Finalizados</a>
			<?php endif; ?>
		</div>
	</div>
	<div class="hamburger" id="menuToggle">
		<span></span>
		<span></span>
		<span></span>
	</div>

</header>
<script>
	const menuBtn = document.getElementById('menuToggle');
const sidebar = document.querySelector('.sidebar');

menuBtn.addEventListener('click', () => {
  menuBtn.classList.toggle('active');
  sidebar.classList.toggle('active');
});

</script>