<?php include_once __DIR__ . '/../Includes/Sidebar.php'; ?>
<main>
    <section class="fondo-login">
        <div class="login">
            <h2 class="bienvenida">Bienvenido a <strong>Innovasys</strong></h2>
            <h3>Iniciar Sesión</h3>

            
            <form class="form" action="/ProyectoPandora/Public/index.php?route=Auth/Login" method="POST">
                <div class="textbox">
                    <input type="email" name="email" required>
                    <label for="email">Email</label>
                </div>

                <div class="textbox">
                    <input type="password" name="password" autocomplete="off" required>
                    <label for="password">Contraseña</label>
                </div>

                <button type="submit">
                    <span class="material-symbols-outlined">Inciar Sesion</span>
                </button>
            </form>
                <a class="footer-login" href="#">¿Olvidaste tu contraseña?</a>
                <p>
                    <a class="footer-login" href="/ProyectoPandora/Public/index.php?route=Register/Register">Registrarse</a>
                </p>

        </div>
    </section>
</main>