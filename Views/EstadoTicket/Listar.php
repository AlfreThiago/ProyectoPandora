<?php include_once __DIR__ . '/../Includes/Header.php' ?>
<main>
    <div class="Tabla-Contenedor">
        <h2>Lista de Estados</h2>
        <div class="serch-container">
            <div>
                <table id="userTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre del Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($estados as $estado): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($estado['id']); ?></td>
                                <td><?php echo htmlspecialchars($estado['name']); ?></td>
                                <td>
                                    <a href="/ProyectoPandora/Public/index.php?route=EstadoTicket/Edit&id=<?php echo $estado['id']; ?>" class="btn edit-btn">Actualizar</a>
                                    <a href="/ProyectoPandora/Public/index.php?route=EstadoTicket/Eliminar&id=<?php echo $estado['id']; ?>" class="btn delete-btn">Eliminar</a>
                                </td>
                            </tr>
                        <?php endforeach;
                        if (empty($estados)): ?>
                            <tr>
                                <td colspan="3">No hay estados disponibles.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <a class="btn newCategory-btn" href="/ProyectoPandora/Public/index.php?route=Dash/CrearEstadoTicket">Agregar Nuevo Estado</a>
            </div>
        </div>

    </div>
</main>
<?php include_once __DIR__ . '/../Includes/Footer.php' ?>