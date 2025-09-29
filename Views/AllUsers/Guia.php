<?php include_once __DIR__ . '/../Includes/Sidebar.php'; ?>

<main>
    <!-- Estilos de Guía consolidados en AdminDash.css -->

    <section class="guia-hero" aria-label="Guía de uso de Innovasys">
        <span class="badge">Guía rápida</span>
        <h1>Cómo usar Innovasys</h1>
        <p>Seguí estos pasos para registrar tus dispositivos, crear tickets y hacer seguimiento de tus reparaciones.</p>
        <div class="guia-cta">
            <a class="btn-prim" href="/ProyectoPandora/Public/index.php?route=Register/Register">Registrarme</a>
            <a class="btn-sec" href="/ProyectoPandora/Public/index.php?route=Auth/Login">Ya tengo cuenta</a>
        </div>
    </section>

    <div class="guia-wrap">
        <div class="guia-grid" role="list" aria-label="Pasos de uso">
            <article class="guia-card" role="listitem">
                <div class="guia-num">1</div>
                <div class="guia-body">
                    <h3>Registro</h3>
                    <p>Creá tu cuenta desde <strong>Registrarse</strong> con tu nombre, email y contraseña.</p>
                </div>
            </article>
            <article class="guia-card" role="listitem">
                <div class="guia-num">2</div>
                <div class="guia-body">
                    <h3>Acceso</h3>
                    <p>Ingresá a tu cuenta desde <strong>Iniciar sesión</strong> para entrar a tu panel.</p>
                </div>
            </article>
            <article class="guia-card" role="listitem">
                <div class="guia-num">3</div>
                <div class="guia-body">
                    <h3>Panel de usuario</h3>
                    <p>Gestioná tus <em>dispositivos</em> y consultá tus <em>tickets</em> en curso.</p>
                </div>
            </article>
            <article class="guia-card" role="listitem">
                <div class="guia-num">4</div>
                <div class="guia-body">
                    <h3>Solicitar reparación</h3>
                    <p>Agregá tu dispositivo y <strong>creá un ticket</strong>. Podés ver el estado en todo momento.</p>
                </div>
            </article>
            <article class="guia-card" role="listitem">
                <div class="guia-num">5</div>
                <div class="guia-body">
                    <h3>Soporte y seguimiento</h3>
                    <p>Ante dudas, consultá la ayuda o contactá a soporte desde tu panel.</p>
                </div>
            </article>
        </div>

        <p class="guia-thanks">¡Gracias por confiar en <strong>Innovasys</strong>! 💜</p>
    </div>
</main>