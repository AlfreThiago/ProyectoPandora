
<?php include_once __DIR__ . '/../Includes/Sidebar.php'; ?>
<?php include_once __DIR__ . '/../Includes/Header.php'; ?>

<main class="asignar-page">
	<section class="content asignar-content">
		<section class="content">
				<header class="header">
					<h1 class="header-title">Asignar Tecnicos a Tickets</h1>
					<p class="header-subtitle">
						Gestiona la asignación de técnicos a los tickets pendientes 👌
					</p>
					<div class="header-actions">
						<!-- Chat  -->
						<span class="icon-btn">
							<i class='bx bx-chat'></i>
						</span>
						<!-- Perfil --> 
						<li class="profile-menu">
							<a href="javascript:void(0)" id="btn-profile">
								<img src="#" alt="Perfil" class="user-avatar">
							</a>

							<!-- Submenú -->
							<div id="submenu-profile" class="submenu">
								<div class="submenu-header">
									<span class="user-avatar"></span>
									<p class="user-name">¡Hola, <?php echo $_SESSION['user']['name']; ?>!</p>
									<small class="user-email"><?php echo $_SESSION['user']['email']; ?></small>
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
											<i class='bx bx-history'></i> 
											<span>Guia</span>
										</a>
									</li>
									<li>
										<a href="#">
											<i class='bx bx-bell-minus'></i>
											<span>Notificaciones</span>
										</a>
									</li>
									<li>
										<a href="/ProyectoPandora/Public/index.php?route=Dash/Ajustes">
											<i class='bxr  bx-cog'></i>
											<span>Ajustes</span>
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

				<!-- Tabs -->
				<div class="tabs">
					<div class="tab <?php echo ($rutaActual === 'Ticket/Listar') ? 'active' : ''; ?>">
						<a href="/ProyectoPandora/Public/index.php?route=Supervisor/Asignar">Asignar Tecnico</a>
					</div>
					<div class="tab <?php echo ($rutaActual === 'Device/ListarDevice') ? 'active' : ''; ?>">
						<a href="/ProyectoPandora/Public/index.php?route=Supervisor/GestionInventario">Gestion Inventario</a>
					</div>
					<div class="tab <?php echo ($rutaActual === 'User/ListarSupers') ? 'active' : ''; ?>">
						<a href="/ProyectoPandora/Public/index.php?route=Supervisor/Presupuestos">Presupuestos</a>
					</div>
				</div>
			</section>

			<?php if (isset($_GET['success'])): ?>
				<div class="alert alert-success">Asignación realizada correctamente.</div>
			<?php elseif (isset($_GET['error'])): ?>
				<div class="alert alert-error">Error: <?php echo htmlspecialchars($_GET['error']); ?></div>
			<?php endif; ?>

		<div class="asignar-panel">
			<form action="/ProyectoPandora/Public/index.php?route=Supervisor/Asignar" method="get" id="filtros" class="filters asignar-filters">
				<input type="hidden" name="route" value="Supervisor/Asignar" />
				<div class="field asignar-field">
					<label class="asignar-label">Filtro disponibilidad</label>
					<select name="estado" id="estado" class="asignar-input">
						<?php $estadoSel = $_GET['estado'] ?? 'todos'; ?>
						<option value="todos" <?php echo $estadoSel==='todos'?'selected':''; ?>>Todos</option>
						<option value="Disponible" <?php echo $estadoSel==='Disponible'?'selected':''; ?>>Disponibles</option>
						<option value="Ocupado" <?php echo $estadoSel==='Ocupado'?'selected':''; ?>>Asignados</option>
					</select>
				</div>
				<div class="field asignar-field asignar-field--grow">
					<label class="asignar-label">Buscar técnico</label>
					<input type="text" name="q" id="q" placeholder="Nombre o especialidad" value="<?php echo htmlspecialchars($_GET['q'] ?? ''); ?>" class="asignar-input" />
				</div>
				<div class="field asignar-field">
					<label class="asignar-label">Ticket</label>
					<select name="ticket_id" id="ticket_id" class="asignar-input">
						<?php if (empty($ticketsSinTecnico)): ?>
							<option value="">No hay tickets sin técnico</option>
						<?php else: ?>
							<option value="">Selecciona un ticket…</option>
							<?php foreach ($ticketsSinTecnico as $t): ?>
								<?php $label = "#{$t['id']} - {$t['dispositivo']} {$t['modelo']} ({$t['cliente']})"; ?>
								<option value="<?php echo (int)$t['id']; ?>" <?php echo (isset($_GET['ticket_id']) && $_GET['ticket_id']==$t['id'])?'selected':''; ?>><?php echo htmlspecialchars($label); ?></option>
							<?php endforeach; ?>
						<?php endif; ?>
					</select>
				</div>
				<div class="actions asignar-actions">
					<button type="submit" class="btn btn-primary">Aplicar</button>
					<a href="/ProyectoPandora/Public/index.php?route=Supervisor/Asignar" class="btn btn-outline">Limpiar</a>
				</div>
			</form>

			<?php
				$estadoFiltro = $_GET['estado'] ?? 'todos';
				$q = strtolower(trim($_GET['q'] ?? ''));
				$filtrados = array_filter($tecnicos ?? [], function($tec) use ($estadoFiltro, $q) {
					$okEstado = ($estadoFiltro === 'todos') || strcasecmp($tec['disponibilidad'] ?? '', $estadoFiltro) === 0;
					if (!$okEstado) return false;
					if ($q === '') return true;
					$hay = strpos(strtolower($tec['name'] ?? ''), $q) !== false
							|| strpos(strtolower($tec['especialidad'] ?? ''), $q) !== false;
					return $hay;
				});
			?>

			<div class="asignar-grid">
				<?php if (empty($filtrados)): ?>
					<div class="asignar-empty">No se encontraron técnicos con esos criterios.</div>
				<?php else: ?>
					<?php foreach ($filtrados as $tec): ?>
						<?php
							$avatar = $tec['img_perfil'] ?? '';
							if (!$avatar) { $avatar = '/ProyectoPandora/Public/img/BIGMOLE-4x.gif'; }
							$estado = $tec['disponibilidad'] ?? 'Desconocido';
							$badgeColor = $estado === 'Disponible' ? '#16a34a' : ($estado==='Ocupado' ? '#ef4444' : '#64748b');
						?>
						<div class="asignar-card">
							<div class="asignar-card__head">
								<img src="<?php echo htmlspecialchars($avatar); ?>" alt="avatar" class="asignar-avatar" />
								<div class="asignar-card__title">
									<div class="asignar-card__row">
										<h3 class="asignar-card__name"><?php echo htmlspecialchars($tec['name'] ?? ''); ?></h3>
										<span class="badge <?php echo $estado==='Disponible' ? 'badge--success' : ($estado==='Ocupado' ? 'badge--danger' : 'badge--muted'); ?>"><?php echo htmlspecialchars($estado); ?></span>
									</div>
									<div class="asignar-card__subtitle">Especialidad: <?php echo htmlspecialchars($tec['especialidad'] ?? '—'); ?></div>
								</div>
							</div>
							<div class="asignar-card__chips">
								<div class="chip">Tickets asignados: <?php echo (int)($tec['tickets_asignados'] ?? 0); ?></div>
								<div class="chip">Email: <?php echo htmlspecialchars($tec['email'] ?? ''); ?></div>
							</div>
							<form action="/ProyectoPandora/Public/index.php?route=Supervisor/AsignarTecnico" method="post" class="asignar-assign-form">
								<input type="hidden" name="tecnico_id" value="<?php echo (int)$tec['id']; ?>" />
								<select name="ticket_id" class="asignar-input asignar-input--small">
									<?php if (empty($ticketsSinTecnico)): ?>
										<option value="">No hay tickets sin técnico</option>
									<?php else: ?>
										<option value="">Selecciona ticket…</option>
										<?php foreach ($ticketsSinTecnico as $t): ?>
											<?php $label = "#{$t['id']} - {$t['dispositivo']} {$t['modelo']}"; ?>
											<option value="<?php echo (int)$t['id']; ?>" <?php echo (isset($_GET['ticket_id']) && $_GET['ticket_id']==$t['id'])?'selected':''; ?>><?php echo htmlspecialchars($label); ?></option>
										<?php endforeach; ?>
									<?php endif; ?>
								</select>
								<button type="submit" class="btn btn-primary" <?php echo ($estado==='Ocupado')?'disabled':''; ?>>Asignar</button>
							</form>
						</div>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
		</div>
	</section>
</main>
<script src="/ProyectoPandora/Public/js/modal.js"></script>
<?php include_once __DIR__ . '/../Includes/Footer.php'; ?>

