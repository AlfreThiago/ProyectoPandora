<?php include_once __DIR__ . '/../Includes/Sidebar.php'; ?>
<main>
<?php include_once __DIR__ . '/../Includes/Header.php'; ?>
    <div class="Tabla-Contenedor">
        <h2>Lista de Estados</h2>
         <div class="botones">
            <div class="btn-table-acciones">
                <a class="btn-acciones-user" href="/ProyectoPandora/Public/index.php?route=EstadoTicket/Crear">Añadir Estado</a>
            </div>
        </div>
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
                        <div class='action-buttons'>
                            <a href="/ProyectoPandora/Public/index.php?route=EstadoTicket/Editar&id=<?php echo $estado['id']; ?>" class="btn edit-btn">Actualizar</a>
                            |
                            <a href="/ProyectoPandora/Public/index.php?route=EstadoTicket/Eliminar&id=<?php echo $estado['id']; ?>" class="btn delete-btn">Eliminar</a>
                        </div>
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
    </div>
</main>
<?php include_once __DIR__ . '/../Includes/Footer.php' ?>