<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="../../Public/css/Style.css">
    <link rel="stylesheet" href="https://unpkg.com/pushbar.js@1.0.0/dist/pushbar.css">
</head>

<body>
    <div class="formulario">
        <div class="Form-conteiner">
                <h2>Registrarse</h2>
                <form action="/ProyectoPandora/Public/index.php?route=user/register" method="POST">
                    <br><label for="name">Nombre</label>
                    <input type="text" name="name" required>
                <br><label for="email">Email</label>
                <input type="email" name="email" required>
                <br><label for="password">Contraseña</label>
                <input type="password" name="password" required>
                <br>
                
                <input type="submit" value="Registrar">
            </form>
    </div>
</div>
</body>
</html>