<?php include_once __DIR__ . '/../Includes/Sidebar.php'; ?>
<main>
    <section class="fondo-login">
        <div class="login">
            <h2 class="bienvenida">Bienvenidos a <strong>Innovasys</strong></h2>
            <h3>Registrarse</h3>

            <?php if (isset($_GET['error']) && $_GET['error'] === 'EmailYaRegistrado'): ?>
                <div style="color: red; margin-bottom: 10px;">
                    El correo electrónico ya está registrado. Por favor, usa otro.
                </div>
            <?php endif; ?>

            <!-- Formulario de registro con mismo estilo que login -->
            <form class="form" action="/ProyectoPandora/Public/index.php?route=Register/Register" method="POST">
                <div class="textbox">
                    <input type="text" name="name" autocomplete="off" required>
                    <label for="name">Nombre</label>
                </div>

                <div class="textbox">
                    <input type="email" name="email" autocomplete="off" required>
                    <label for="email">Email</label>
                </div>

                <div class="textbox">
                    <input type="password" name="password" autocomplete="off" required>
                    <label for="password">Contraseña</label>
                </div>

                <button type="submit">
                    <p>Sign up</p>
                    <span class="material-symbols-outlined">person_add</span>
                </button>
            </form>

            <p>
                <a class="footer-login" href="/ProyectoPandora/Public/index.php?route=Auth/Login">¿Ya tenés cuenta? Iniciar sesión</a>
            </p>
            <p>
                <a class="footer-login" href="/ProyectoPandora/Public/index.php?route=Default/Index">Volver al inicio</a>
            </p>
        </div>
    </section>
</main>
<?php include_once __DIR__ . '/../Includes/Footer.php'; ?>
