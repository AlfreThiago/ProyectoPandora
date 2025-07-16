<?php
if (isset($_GET['error']) && $_GET['error'] === 'EmailYaRegistrado'): ?>
    <div style="color: red; margin-bottom: 10px;">
        El correo electrónico ya está registrado. Por favor, usa otro.
    </div>
<?php endif; ?>
<main>
    <section class="Conenedor-formulario-principal">
        <h2>Registrarse</h2>
        <div class="Formulario-general">
            <div class="Formulario-contenedor">
                <form action="/ProyectoPandora/Public/index.php?route=Register/RegisterAdminPortal" method="POST">
                    <p>
                        <label for="name">Nombre:</label>
                        <input type="text" name="name">
                    </p>
                    <p>
                        <label for="email">Email</label>
                        <input type="email" name="email" required>
                    </p>
                    <p>
                        <label for="password">password</label>
                        <input type="password" name="password" required>
                    </p>
                    <p>
                        <button type="submit">Registrar</button>
                    </p>
                </form>
            </div>
        </div>