<?php
include_once __DIR__ . '/../Includes/Header.php'
?>
<main>
    <div>
        <h2>Actualizar Estado</h2>
        <form method="POST" action="/ProyectoPandora/Public/index.php?route=EstadoTicket/Actualizar">
            <input type="hidden" name="id" value="<?= $estado['id'] ?>">
            <label>Nombre del estado:</label>
            <input type="text" name="name" value="<?= $estado['name'] ?>" required>
            <button type="submit">Actualizar</button>
        </form>
    </div>
</main>
<?php
include_once __DIR__ . '/../Includes/Footer.php'
?>