<?php
// Esta parte carga el header general y el módulo de autenticación
include_once __DIR__ . '/../Includes/AuthHeader.php';

// Si se detecta el error 'EmailYaRegistrado', avisamos que el correo está registrado
if (isset($_GET['error']) && $_GET['error'] === 'EmailYaRegistrado'): ?>
    <div style="color: red; margin-bottom: 10px;">
        El correo electrónico ya está registrado. Por favor, usa otro.
    </div>
<?php endif; ?>

<body>
    <main>
        <div class="Contenedor">
            <section class="Conenedor-formulario-principal">
                <h2>Registrarse</h2>
                <div class="Formulario-general">
                    <div class="Formulario-contenedor">
                        <!-- Formulario para registrar un nuevo usuario -->
                        <form action="/ProyectoPandora/Public/index.php?route=Register/Register" method="POST">
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
            </section>
        </div>
    </main>
</body>