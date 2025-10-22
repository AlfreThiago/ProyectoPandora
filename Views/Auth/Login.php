<?php include_once __DIR__ . '/../Includes/Sidebar.php'; ?>
<main>
    <section class="fondo-login">
        <div class="login">
            <h2 class="bienvenida">Bienvenido a <strong>Innovasys</strong></h2>
            <h3>Iniciar Sesión</h3>

            <form class="form" id="loginForm" method="post" action="/ProyectoPandora/Public/index.php?route=Auth/Login">
                <div class="textbox">
                    <input type="email" name="email" id="email" required>
                    <label for="email">Email</label>
                </div>

                <div class="textbox">
                    <input type="password" name="password" id="password" autocomplete="off" required>
                    <label for="password">Contraseña</label>
                </div>

                <button type="submit">
                    <span class="material-symbols-outlined">Iniciar Sesión</span>
                </button>
            </form>

            <!-- ZONA DE RESPUESTA -->
            <div id="respuesta" style="margin-top: 10px; color: red;"></div>

            <a class="footer-login" href="#">¿Olvidaste tu contraseña?</a>
            <p>
                <a class="footer-login" href="/ProyectoPandora/Public/index.php?route=Register/Register">Registrarse</a>
            </p>
        </div>
    </section>
</main>


