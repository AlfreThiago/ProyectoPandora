<?php
// Esta parte carga el header general y el módulo de autenticación
include_once __DIR__ . '/../Includes/AuthHeader.php';
?>

<body>

    <main>
        <div class="Contenedor">

            <section class="Conenedor-formulario-principal">
                <h2>Iniciar Sesión</h2>

                <div class="Formulario-general">
                    <div class="Formulario-contenedor">
                        <!-- Aca el usuario ingrese su email y contraseña -->
                        <!-- Al enviar, los datos se envían a la ruta Auth/Login -->
                        <form action="/ProyectoPandora/Public/index.php?route=Auth/Login" method="POST">
                            <p>
                                <label for="email">Email</label>
                                <input type="email" name="email" required>
                            </p>

                            <p>
                                <label for="password">Password</label>
                                <input type="password" name="password" required>
                            </p>

                            <p class="btn">
                                <button type="submit">Log in</button>
                            </p>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </main>
</body>