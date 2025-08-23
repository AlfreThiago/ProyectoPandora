<?php include_once __DIR__ . '/../Includes/Header.php' ?>
<main>
    <div class="Tabla-Contenedor">
        <h2>Lista de Dispositivos</h2>
        <div class="search-container">
            <input type="text" id="userSearchInput" placeholder="Buscar usuario..." class="search-input">
        </div>
        <table id="userTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Categoria</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Descripcion de Falla</th>
                    <th>Imagen</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($dispositivos)) {
                    foreach ($dispositivos as $dispositivo) {
                        echo "<td>{$dispositivo['id']}</td>";
                        echo "<td>{$dispositivo['users']}</td>";
                        echo "<td>{$dispositivo['categoria']}</td>";
                        echo "<td>{$dispositivo['marca']}</td>";
                        echo "<td>{$dispositivo['modelo']}</td>";
                        echo "<td>{$dispositivo['descripcion_falla']}</td>";
                        echo "<td><img src='/ProyectoPandora/Public/img/imgDispositivos/{$dispositivo['img_dispositivo']}' width='80'></td>";
                        echo "<td><a href='/ProyectoPandora/Public/index.php?route=Device/ActualizarDevice&id={$dispositivo['id']}' class='btn edit-btn'>Actualizar</a>
                                    <a href='/ProyectoPandora/Public/index.php?route=Device/DeleteDevice&id={$dispositivo['id']}' class='btn delete-btn'>Eliminar</a>
                                </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No hay dispositivos registrados.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</main>
<?php include_once __DIR__ . '/../Includes/Footer.php' ?>