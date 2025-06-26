<?php
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../Public/css/Style.css">
</head>

<body>
    <div class="dash-conteiner">

        <h2>
            Bienvenido al Dashboard!
            <br>
            <?php
            session_start();
            if (isset($_SESSION['user'])) {
                echo 'Bienvenido, ' . htmlspecialchars($_SESSION['user']['username']);
            } else {
                echo 'Por favor, inicie sesión.';
            }
            ?>
        </h2>
    </div>

</body>

</html>