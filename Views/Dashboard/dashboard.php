<?php
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>
        Bienvenido al Dashboard!
        <br>
        <?php
        session_start();
        if (isset($_SESSION['user'])) {
            echo 'Bienvenido, ' . htmlspecialchars($_SESSION['user']['name']);
        } else {
            echo 'Por favor, inicie sesión.';
        }
        ?>
    </h1>

</body>

</html>