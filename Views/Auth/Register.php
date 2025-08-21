<?php include_once __DIR__ . '/../Includes/Header.php'; ?>
<main>
    <?phP
    if (isset($_GET['error']) && $_GET['error'] === 'EmailYaRegistrado'): ?>
        <div style="color: red; margin-bottom: 10px;">
            El correo electrónico ya está registrado. Por favor, usa otro.
        </div>
    <?php endif; ?>
    <div class="Contenedor">
        <section class="Conenedor-formulario-principal">
            <h2>Registrarse</h2>
            <div class="Formulario-general">
                <div class="Formulario-contenedor">

                    <form action="/ProyectoPandora/Public/index.php?route=Register/Register" method="POST">
                        <p>
                            <label for="name">Nombre:</label>
                            <input type="text" name="name" autocomplete="off" required>
                        </p>
                        <p>
                            <label for="email">Email</label>
                            <input type="email" name="email" autocomplete="off" required>
                        </p>
                        <p>
                            <label for="password">password</label>
                            <input type="password" name="password" autocomplete="off" required>
                        </p>
                        <p>
                            <button type="submit">Registrar</button>
                        </p>
                    </form>
                </div>
            </div>
        </section>
    </div>
</main>
<?php include_once __DIR__ . '/../Includes/Footer.php'; ?>