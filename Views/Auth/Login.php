<?php include_once __DIR__ . '/../Shared/AuthHeader.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <main>
        <section class="Conenedor-formulario-principal">
            <h2>Iniciar Sesión</h2>

            <div class="Formulario-general">
                <div class="Formulario-contenedor">

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
    </main>
</body>

</html>