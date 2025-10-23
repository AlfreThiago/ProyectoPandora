<?php 
include_once __DIR__ . '/../Includes/Sidebar.php'; 
$role = strtolower($authUser['role'] ?? 'invitado');
require_once __DIR__ . '/../../Core/Date.php';
?>

<main>
    <?php include_once __DIR__ . '/../Includes/Header.php'; ?>

    <div class="home-container">
        <!-- HERO -->
        <section class="home-hero">
            <div class="hero-left">
                <h2><i class='bx bx-grid-alt'></i> Portal de gestión — todo en un solo lugar</h2>
                <p>Accedé rápido a tus herramientas, tickets y dispositivos. Cada rol tiene su propio espacio para facilitar la gestión y comunicación.</p>
                <div class="home-cta">
                    <?php if ($role === 'invitado'): ?>
                        <a class="btn-a" href="index.php?route=Auth/Login"><i class='bx bx-log-in'></i> Iniciar sesión</a>
                        <a class="btn-b" href="index.php?route=Register/Register"><i class='bx bx-user-plus'></i> Registrarse</a>
                    <?php elseif ($role === 'cliente'): ?>
                        <a class="btn-a" href="index.php?route=Cliente/MisTicketActivo"><i class='bx bx-support'></i> Ver mis tickets</a>
                        <a class="btn-b" href="index.php?route=Cliente/MisDevice"><i class='bx bx-laptop'></i> Mis dispositivos</a>
                        <a class="btn-c" href="index.php?route=Ticket/Crear"><i class='bx bx-plus-circle'></i> Crear ticket</a>
                    <?php elseif ($role === 'tecnico'): ?>
                        <a class="btn-a" href="index.php?route=Tecnico/MisReparaciones"><i class='bx bx-wrench'></i> Mis reparaciones</a>
                        <a class="btn-b" href="index.php?route=Tecnico/MisStats"><i class='bx bx-line-chart'></i> Mis estadísticas</a>
                    <?php elseif ($role === 'supervisor'): ?>
                        <a class="btn-a" href="index.php?route=Supervisor/Asignar"><i class='bx bx-user-voice'></i> Asignar técnico</a>
                        <a class="btn-b" href="index.php?route=Supervisor/Presupuestos"><i class='bx bx-wallet'></i> Ver presupuestos</a>
                    <?php elseif ($role === 'administrador'): ?>
                        <a class="btn-a" href="index.php?route=Admin/ListarUsers"><i class='bx bx-user'></i> Gestión de usuarios</a>
                        <a class="btn-b" href="index.php?route=Historial/ListarHistorial"><i class='bx bx-history'></i> Historial del sistema</a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="hero-right">
                <div class="hero-stats">
                    <div class="stat">
                        <i class='bx bx-time-five'></i>
                        <span class="num" id="activeTickets"><?= isset($stats['activeTickets']) ? (int)$stats['activeTickets'] : 0 ?></span>
                        <span class="label">Tickets activos</span>
                    </div>
                    <div class="stat">
                        <i class='bx bx-star'></i>
                        <span class="num" id="avgRating"><?= isset($stats['avgRating']) && $stats['avgRating'] !== null ? $stats['avgRating'] : '—' ?></span>
                        <span class="label">Promedio general</span>
                    </div>
                    <div class="stat">
                        <i class='bx bx-refresh'></i>
                        <span class="num" id="lastUpdate">
                            <?php if (!empty($stats['lastUpdateIso'])): ?>
                                <time title="<?= htmlspecialchars(DateHelper::exact($stats['lastUpdateIso'])) ?>">
                                    <?= htmlspecialchars(DateHelper::smart($stats['lastUpdateIso'])) ?>
                                </time>
                            <?php else: ?>
                                —
                            <?php endif; ?>
                        </span>
                        <span class="label">Última actualización</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- CONTENIDO PRINCIPAL -->
        <div class="home-wrap">
            <div class="home-grid">

            
                <!-- NOVEDADES -->
                <section class="home-news card-wide">
                    <h3><i class='bx bx-news'></i> Novedades</h3>
                    <ul>
                        <li><strong>Nuevo:</strong> Seguimiento de repuestos en tiempo real disponible.</li>
                        <li><strong>Info:</strong> Mantenimiento programado — 12 Oct (00:00 - 02:00)</li>
                        <li><strong>Tip:</strong> Recordá calificar al técnico tras finalizar tu reparación.</li>
                    </ul>
                </section>

                <!-- ESTADÍSTICAS -->
                <section class="home-charts card-wide">
                <h3><i class='bx bx-analyse'></i> Estadísticas del sistema</h3>
                <div class="charts-grid">

                    <!-- GRÁFICA 1: Tickets activos vs finalizados -->
                    <div class="chart-box">
                    <h4><i class='bx bx-pie-chart'></i> Estado de tickets</h4>
                    <canvas id="ticketsChart"></canvas>
                    </div>

                    <!-- GRÁFICA 2: Ranking de técnicos -->
                    <div class="chart-box">
                    <h4><i class='bx bx-medal'></i> Ranking de técnicos</h4>
                    <canvas id="rankingChart"></canvas>
                    </div>

                    <!-- GRÁFICA 3: Promedio general o reparaciones por categoría -->
                    <div class="chart-box">
                    <h4><i class='bx bx-bar-chart-alt'></i> Reparaciones por categoría</h4>
                    <canvas id="categoryChart"></canvas>
                    </div>

                </div>
                </section>


                <!-- AYUDA -->
                <section class="help card-wide">
                    <h3><i class='bx bx-question-mark'></i> ¿Necesitás ayuda?</h3>
                    <p>Contactá al soporte o revisá la documentación rápida.</p>
                </section>
            </div>
        </div>

        <footer class="footer">
            <small>© <span id="year"></span> Innovasys — Portal</small>
        </footer>
    </div>

    <script>
        document.getElementById('year').textContent = new Date().getFullYear();
    </script>
</main>
<script>
document.getElementById('year').textContent = new Date().getFullYear();

// ======= GRÁFICA 1 =======
const ctx1 = document.getElementById('ticketsChart');
new Chart(ctx1, {
  type: 'doughnut',
  data: {
    labels: ['Activos', 'Finalizados'],
    datasets: [{
      data: [5, 12], // ACA VAN LOS DATOS REALES OK NICOLAS
      backgroundColor: ['#58a6ff', '#2ea043'],
      borderColor: '#0d1117',
      borderWidth: 2
    }]
  },
  options: {
    plugins: {
      legend: { labels: { color: '#c9d1d9' } },
      title: {
        display: true,
        text: 'Tickets activos vs finalizados',
        color: '#c9d1d9'
      }
    }
  }
});

// ======= GRÁFICA 2 =======
const ctx2 = document.getElementById('rankingChart');
new Chart(ctx2, {
  type: 'bar',
  data: {
    labels: ['Lucas', 'Ana', 'Carlos', 'María', 'José'], //datos nico
    datasets: [{
      label: 'Puntaje de honor',
      data: [95, 88, 76, 92, 84],
      backgroundColor: 'rgba(255, 214, 10, 0.6)',
      borderColor: 'rgba(255, 214, 10, 1)',
      borderWidth: 1
    }]
  },
  options: {
    plugins: {
      legend: { labels: { color: '#c9d1d9' } },
      title: {
        display: true,
        text: 'Ranking de técnicos',
        color: '#c9d1d9'
      }
    },
    scales: {
      x: {
        ticks: { color: '#c9d1d9' },
        grid: { color: 'rgba(255,255,255,0.1)' }
      },
      y: {
        ticks: { color: '#c9d1d9' },
        grid: { color: 'rgba(255,255,255,0.1)' }
      }
    }
  }
});

// ======= GRÁFICA 3 =======
const ctx3 = document.getElementById('categoryChart');
new Chart(ctx3, {
  type: 'line',
  data: {
    labels: ['PC', 'Notebook', 'Celular', 'Tablet', 'Otros'], //mas datos nico
    datasets: [{
      label: 'Reparaciones',
      data: [10, 14, 6, 3, 4],
      borderColor: '#f78166',
      backgroundColor: 'rgba(247,129,102,0.3)',
      tension: 0.3,
      fill: true
    }]
  },
  options: {
    plugins: {
      legend: { labels: { color: '#c9d1d9' } },
      title: {
        display: true,
        text: 'Reparaciones por categoría',
        color: '#c9d1d9'
      }
    },
    scales: {
      x: {
        ticks: { color: '#c9d1d9' },
        grid: { color: 'rgba(255,255,255,0.1)' }
      },
      y: {
        ticks: { color: '#c9d1d9' },
        grid: { color: 'rgba(255,255,255,0.1)' }
      }
    }
  }
});
</script>
