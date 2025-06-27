<?php include_once __DIR__ . '/../Shared/AuthHeader.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <div class="formulario">
        <div class="Form-conteiner">
            <h2>Iniciar Sesión</h2>
            <form method="POST" action="/ProyectoPandora/Public/index.php?route=Auth/Login">
                <label for="email">Email</label>
                <input type="email" name="email" required>
                <label for="password">Password</label>
                <input type="password" name="password" required>

                <input type="submit" value="Log in">
            </form>
        </div>
    </div>
</body>

</html>