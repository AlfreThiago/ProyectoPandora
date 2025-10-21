<?php include_once __DIR__ . '/../Includes/Sidebar.php'; ?>

<main>
    <?php include_once __DIR__ . '/../Includes/Header.php'; ?>
    <div class="Contenedor">
        <section class="tecnico-stats">
            <div class="stats-grid">
                <div class="stat-card">
                    <span class="stat-num"><?= (int)($counters['finalizados'] ?? 0) ?></span>
                    <span class="stat-label">Tickets finalizados</span>
                </div>
                <div class="stat-card">
                    <span class="stat-num"><?= (int)($counters['activos'] ?? 0) ?></span>
                    <span class="stat-label">Tickets activos</span>
                </div>
                <div class="stat-card">
                    <span class="stat-num"><?= isset($avg) ? htmlspecialchars(number_format((float)$avg,1,'.','')) : '—' ?></span>
                    <span class="stat-label">Honor promedio (★)</span>
                </div>
                <div class="stat-card">
                    <span class="stat-num"><?= (int)($count ?? 0) ?></span>
                    <span class="stat-label">Calificaciones</span>
                </div>
            </div>

            <div class="labor-range">
                <h3>Rango de mano de obra</h3>
                <form method="post" action="/ProyectoPandora/Public/index.php?route=Tecnico/ActualizarStats" class="form-inline">
                    <label style="color: white;">Mín:</label>
                    <input type="number" step="0.01" min="0" name="labor_min" value="<?= htmlspecialchars($stats['labor_min'] ?? 0) ?>" class="asignar-input asignar-input--small"/>
                    <label style="color: white;">Máx:</label>
                    <input type="number" step="0.01" min="0" name="labor_max" value="<?= htmlspecialchars($stats['labor_max'] ?? 0) ?>" class="asignar-input asignar-input--small"/>
                    <button class="btn btn-primary" type="submit">Guardar</button>
                </form>
            </div>

            <div class="timer-box">
                <h3>Temporizador de reparación</h3>
                <div class="timer-display" id="timer">00:00:00</div>
                <div class="card-actions">
                    <button class="btn btn-primary" id="startBtn" type="button">Iniciar</button>
                    <button class="btn btn-outline" id="pauseBtn" type="button">Pausar</button>
                    <button class="btn btn-outline" id="resetBtn" type="button">Reiniciar</button>
                </div>
            </div>
        </section>
    </div>
</main>

<script>
    let timerInterval=null, elapsed=0, running=false;
    const el=document.getElementById('timer');
    function fmt(s){const h=Math.floor(s/3600), m=Math.floor((s%3600)/60), sec=s%60; return `${String(h).padStart(2,'0')}:${String(m).padStart(2,'0')}:${String(sec).padStart(2,'0')}`}
    function tick(){elapsed++; el.textContent=fmt(elapsed)}
    document.getElementById('startBtn').onclick=()=>{ if(!running){ timerInterval=setInterval(tick,1000); running=true; }}
    document.getElementById('pauseBtn').onclick=()=>{ if(running){ clearInterval(timerInterval); running=false; }}
    document.getElementById('resetBtn').onclick=()=>{ clearInterval(timerInterval); running=false; elapsed=0; el.textContent=fmt(0); }
</script>

