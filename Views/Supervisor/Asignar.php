
<?php include_once __DIR__ . '/../Includes/Sidebar.php'; ?>
<?php include_once __DIR__ . '/../Includes/Header.php'; ?>

<?php
// Variables esperadas: $tecnicos (array), $ticketsSinTecnico (array)
$paletaPrimaria = '#0ea5e9';
$paletaFondo = '#0b1220';
$paletaCard = 'rgba(255,255,255,0.04)';
$paletaTexto = '#e5e7eb';
?>

<main>
	<section class="content" style="padding: 24px;">
		<header class="header" style="margin-bottom: 16px;">
			<h1 class="header-title">Asignar Técnicos a Tickets</h1>
			<p class="header-subtitle">Gestiona asignaciones de forma rápida y visual</p>
		</header>

			<?php if (isset($_GET['success'])): ?>
				<div style="margin: 8px 0 16px; background: rgba(34,197,94,0.15); border:1px solid rgba(34,197,94,0.35); color:#86efac; padding:10px 12px; border-radius:8px;">Asignación realizada correctamente.</div>
			<?php elseif (isset($_GET['error'])): ?>
				<div style="margin: 8px 0 16px; background: rgba(239,68,68,0.15); border:1px solid rgba(239,68,68,0.35); color:#fecaca; padding:10px 12px; border-radius:8px;">Error: <?php echo htmlspecialchars($_GET['error']); ?></div>
			<?php endif; ?>

		<div class="panel" style="display:grid; gap:16px;">
			<form action="/ProyectoPandora/Public/index.php?route=Supervisor/Asignar" method="get" id="filtros" class="filters" style="display:flex; flex-wrap:wrap; gap:12px; align-items:center;">
				<input type="hidden" name="route" value="Supervisor/Asignar" />
				<div class="field" style="min-width:220px;">
					<label style="display:block; font-size:12px; opacity:.8; margin-bottom:6px;">Filtro disponibilidad</label>
					<select name="estado" id="estado" class="input" style="width:100%; padding:10px 12px; border-radius:8px; background: <?php echo $paletaCard;?>; color: <?php echo $paletaTexto;?>; border:1px solid rgba(255,255,255,0.08);">
						<?php $estadoSel = $_GET['estado'] ?? 'todos'; ?>
						<option value="todos" <?php echo $estadoSel==='todos'?'selected':''; ?>>Todos</option>
						<option value="Disponible" <?php echo $estadoSel==='Disponible'?'selected':''; ?>>Disponibles</option>
						<option value="Ocupado" <?php echo $estadoSel==='Ocupado'?'selected':''; ?>>Asignados</option>
					</select>
				</div>
				<div class="field" style="min-width:260px; flex:1;">
					<label style="display:block; font-size:12px; opacity:.8; margin-bottom:6px;">Buscar técnico</label>
					<input type="text" name="q" id="q" placeholder="Nombre o especialidad" value="<?php echo htmlspecialchars($_GET['q'] ?? ''); ?>" class="input" style="width:100%; padding:10px 12px; border-radius:8px; background: <?php echo $paletaCard;?>; color: <?php echo $paletaTexto;?>; border:1px solid rgba(255,255,255,0.08);" />
				</div>
				<div class="field" style="min-width:260px;">
					<label style="display:block; font-size:12px; opacity:.8; margin-bottom:6px;">Ticket</label>
					<select name="ticket_id" id="ticket_id" class="input" style="width:100%; padding:10px 12px; border-radius:8px; background: <?php echo $paletaCard;?>; color: <?php echo $paletaTexto;?>; border:1px solid rgba(255,255,255,0.08);">
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
				<div class="actions" style="display:flex; gap:8px; align-self:flex-end;">
					<button type="submit" class="btn" style="background: <?php echo $paletaPrimaria;?>; color:white; padding:10px 14px; border:none; border-radius:8px;">Aplicar</button>
					<a href="/ProyectoPandora/Public/index.php?route=Supervisor/Asignar" class="btn" style="background:transparent; color:<?php echo $paletaTexto;?>; padding:10px 14px; border:1px solid rgba(255,255,255,0.12); border-radius:8px; text-decoration:none;">Limpiar</a>
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

			<div class="grid" style="display:grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap:16px;">
				<?php if (empty($filtrados)): ?>
					<div style="opacity:.8;">No se encontraron técnicos con esos criterios.</div>
				<?php else: ?>
					<?php foreach ($filtrados as $tec): ?>
						<?php
							$avatar = $tec['img_perfil'] ?? '';
							if (!$avatar) { $avatar = '/ProyectoPandora/Public/img/BIGMOLE-4x.gif'; }
							$estado = $tec['disponibilidad'] ?? 'Desconocido';
							$badgeColor = $estado === 'Disponible' ? '#16a34a' : ($estado==='Ocupado' ? '#ef4444' : '#64748b');
						?>
						<div class="card" style="background: <?php echo $paletaCard;?>; border:1px solid rgba(255,255,255,0.06); border-radius:14px; padding:16px; display:flex; flex-direction:column; gap:12px;">
							<div style="display:flex; gap:12px; align-items:center;">
								<img src="<?php echo htmlspecialchars($avatar); ?>" alt="avatar" style="width:56px; height:56px; border-radius:50%; object-fit:cover; border:2px solid rgba(255,255,255,0.12);" />
								<div style="flex:1;">
									<div style="display:flex; align-items:center; gap:8px;">
										<h3 style="margin:0; color:<?php echo $paletaTexto;?>; font-size:16px; font-weight:600;"><?php echo htmlspecialchars($tec['name'] ?? ''); ?></h3>
										<span style="display:inline-block; font-size:11px; background: <?php echo $badgeColor;?>; color:white; padding:2px 8px; border-radius:999px;"><?php echo htmlspecialchars($estado); ?></span>
									</div>
									<div style="font-size:12px; opacity:.8;">Especialidad: <?php echo htmlspecialchars($tec['especialidad'] ?? '—'); ?></div>
								</div>
							</div>
							<div style="display:flex; gap:12px; flex-wrap:wrap; font-size:12px; opacity:.9;">
								<div style="background:rgba(255,255,255,0.06); padding:6px 10px; border-radius:8px;">Tickets asignados: <?php echo (int)($tec['tickets_asignados'] ?? 0); ?></div>
								<div style="background:rgba(255,255,255,0.06); padding:6px 10px; border-radius:8px;">Email: <?php echo htmlspecialchars($tec['email'] ?? ''); ?></div>
							</div>
							<form action="/ProyectoPandora/Public/index.php?route=Supervisor/AsignarTecnico" method="post" style="display:flex; gap:8px; align-items:center; margin-top:4px;">
								<input type="hidden" name="tecnico_id" value="<?php echo (int)$tec['id']; ?>" />
								<select name="ticket_id" class="input" style="flex:1; padding:8px 10px; border-radius:8px; background: <?php echo $paletaCard;?>; color: <?php echo $paletaTexto;?>; border:1px solid rgba(255,255,255,0.08);">
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
								<button type="submit" class="btn" style="background: <?php echo $paletaPrimaria;?>; color:white; padding:10px 12px; border:none; border-radius:8px; white-space:nowrap;" <?php echo ($estado==='Ocupado')?'disabled':''; ?>>Asignar</button>
							</form>
						</div>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
		</div>
	</section>
</main>

<?php include_once __DIR__ . '/../Includes/Footer.php'; ?>

