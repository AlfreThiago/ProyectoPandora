<main>
    <?php
    require_once __DIR__ . '/../../../Models/Device.php';
    require_once __DIR__ . '/../../../Core/Database.php';

    $db = new Database();
    $db->connectDatabase();
    $deviceModel = new DeviceModel($db->getConnection());
    $dispositivos = $deviceModel->getAllDevices();
    ?>
    <div class="Tabla-Contenedor">
        <h2>Dispositivos</h2>

        <!-- sirve para buscar usuarios en la tabla mientras escribís -->
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
                if ($dispositivos && count($dispositivos) > 0) {
                    foreach ($dispositivos as $dispositivo) {
                        echo "<>";
                        echo "<td>{$dispositivo['id']}</td>";
                        echo "<td>{$dispositivo['users']}</td>";
                        echo "<td>{$dispositivo['categoria']}</td>"; // ← aquí el nombre
                        echo "<td>{$dispositivo['marca']}</td>";
                        echo "<td>{$dispositivo['modelo']}</td>";
                        echo "<td>{$dispositivo['descripcion_falla']}</td>";
                        echo "<td><img src='/ProyectoPandora/Public/img/imgDispositivos/{$dispositivo['img_dispositivo']}' width='80'></td>";
                        echo "<td><a href='/ProyectoPandora/Public/index.php?route=Device/Edit-device&id={$dispositivo['id']}' class='btn edit-btn'>Editar</a>
                                    <a href='/ProyectoPandora/Public/index.php?route=Device/Delete-device&id={$dispositivo['id']}' class='btn delete-btn'>Eliminar</a>
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
    <div class="dark-mode-btn" id="dark-mode-btn">
        <i class='bx bx-sun'></i>
        <i class='bx bx-moon'></i>
    </div>
    <script src="/ProyectoPandora/Public/js/Buscador.js"></script>
</main>