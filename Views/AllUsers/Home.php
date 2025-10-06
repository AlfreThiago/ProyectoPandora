<?php 
include_once __DIR__ . '/../Includes/Sidebar.php'; ?>

<main>
<?php include_once __DIR__ . '/../Includes/Header.php'; ?>

  <div class="app-shell">
    <!-- MAIN -->
    <main class="main">
      <header class="topbar">
        <div class="greeting">
          <h1>👋 ¡Hola, <span class="user">Nicolas</span>!</h1>
          <p class="muted">Home Portal · Bienvenido al sistema</p>
        </div>
        <div class="actions">
          <div class="theme-toggle" role="group" aria-label="theme">
            <button id="themeBtn">🌙</button>
          </div>
        </div>
      </header>

      <!-- HERO -->
      <section class="home-hero">
        <div class="hero-left">
          <h2>Portal de gestión — todo en un solo lugar</h2>
          <p>Accedé rápido a tus tickets, dispositivos y calificaciones. Recomendado para mantener seguimiento y transparencia en cada servicio.</p>
          <div class="home-cta">
            <a class="btn-a" href="#">Ver mis tickets</a>
            <a class="btn-b" href="#">Registrar dispositivo</a>
            <a class="btn-c" href="#">Crear ticket rápido</a>
          </div>
        </div>
        <div class="hero-right">
          <div class="hero-stats">
            <div class="stat">
              <span class="num" id="activeTickets">3</span>
              <span class="label">Tickets activos</span>
            </div>
            <div class="stat">
              <span class="num">⭐ 4.8</span>
              <span class="label">Promedio de calificación</span>
            </div>
            <div class="stat">
              <span class="num">24h</span>
              <span class="label">Última actualización</span>
            </div>
          </div>
        </div>
      </section>

      <!-- QUICK ACTIONS + CARDS -->
      <div class="home-wrap">
        <div class="home-grid">

          <article class="home-card">
            <svg class="card-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M3 12h18"/></svg>
            <div>
              <h3>Seguimiento en tiempo real</h3>
              <p>Consultá el estado de tus tickets y recibí notificaciones cuando haya novedades.</p>
              <a class="home-link" href="#">Ver tickets →</a>
            </div>
          </article>

          <article class="home-card">
            <svg class="card-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3v18"/></svg>
            <div>
              <h3>Presupuestos claros</h3>
              <p>Detalle de repuestos y mano de obra con aprobación del cliente antes de reparar.</p>
              <a class="home-link" href="#">Ver presupuestos →</a>
            </div>
          </article>

          <article class="home-card">
            <svg class="card-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 5l7 7-7 7-7-7z"/></svg>
            <div>
              <h3>Calificación del servicio</h3>
              <p>Evaluá a tu técnico al finalizar; nos ayuda a mejorar y balancear cargas.</p>
              <a class="home-link" href="#">Calificar servicio →</a>
            </div>
          </article>

          <!-- Novedades / Anuncios -->
          <section class="home-news card-wide">
            <h3>🗞️ Novedades</h3>
            <ul>
              <li><strong>Nuevo:</strong> Seguimiento de repuestos en tiempo real disponible.</li>
              <li><strong>Info:</strong> Mantenimiento programado — 12 Oct. (00:00 - 02:00)</li>
              <li><strong>Tip:</strong> Recordá calificar al técnico para mejorar la red de servicios.</li>
            </ul>
          </section>

          <!-- QUICK ACTIONS -->
          <aside class="quick-actions card-wide">
            <h3>Accesos rápidos</h3>
            <div class="qa-grid">
              <a class="qa" href="#">➕ Crear ticket</a>
              <a class="qa" href="#">📁 Mis dispositivos</a>
              <a class="qa" href="#">📊 Reportes</a>
              <a class="qa" href="#">🧾 Facturación</a>
            </div>
          </aside>

          <!-- SUGGESTION / HELP -->
          <section class="help card-wide">
            <h3>¿Necesitás ayuda?</h3>
            <p>Contactá al equipo de soporte o consultá la documentación rápida. También podés ver tutoriales en video para crear tickets correctamente.</p>
            <a class="home-link" href="#">Ir a soporte →</a>
          </section>

        </div>
      </div>
    </main>
  </div>

  <script>
    // Pequeñas interacciones demo (no persistentes)
    document.getElementById('year').textContent = new Date().getFullYear();
    const themeBtn = document.getElementById('themeBtn');
    themeBtn.addEventListener('click', () => {
      document.documentElement.classList.toggle('light-mode');
      themeBtn.textContent = document.documentElement.classList.contains('light-mode') ? '🌤️' : '🌙';
    });

    // Demo: animar número de tickets
    const active = document.getElementById('activeTickets');
    let n = parseInt(active.textContent,10);
    setInterval(()=>{
      n = n + (Math.random() > .7 ? 1 : 0);
      active.textContent = n;
    }, 6000);
  </script>

</main>