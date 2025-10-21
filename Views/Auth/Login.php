<?php include_once __DIR__ . '/../Includes/Sidebar.php'; ?>
<main>
    <section class="fondo-login">
        <div class="login">
            <h2 class="bienvenida">Bienvenido a <strong>Innovasys</strong></h2>
            <h3>Iniciar Sesión</h3>

            <form class="form" id="loginForm">
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

<!-- script AJAX -->
<script>
document.getElementById('loginForm').addEventListener('submit', function(e) {
    e.preventDefault(); // no recarga la página

    const form = e.target;
    const formData = new FormData(form);

    // url del backend php que procesa el login
    const url = '/ProyectoPandora/Public/index.php?route=Auth/Login';

    fetch(url, {
        method: 'POST',
        body: formData
    })
    .then(resp => resp.text()) // si el backend responde html, usar .text()
    .then(data => {
        // muestra la respuesta del servidor
        document.getElementById('respuesta').innerHTML = data;

    })
    .catch(err => {
        document.getElementById('respuesta').textContent = 'Error: ' + err;
    });
});
</script>

