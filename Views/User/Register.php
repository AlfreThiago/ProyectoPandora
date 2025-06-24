<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="/ProyectoPandora/Public/index.php?route=user/register" method="POST">
        <label for="name">Nombre</label>
        <input type="text" name="name" required>
        <label for="email">Email</label>
        <input type="email" name="email" required>
        <label for="password">Contraseña</label>
        <input type="password" name="password" required>

        <button type="submit">Registrar</button>
    </form>

</body>

</html>