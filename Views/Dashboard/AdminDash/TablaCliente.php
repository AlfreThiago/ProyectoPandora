<head>
   <!-- Archivo CSS de Boxicons para los íconos de la UI -->
    <link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>
</head>
<main>
    <div class="Tabla-Contenedor">
        <h2>Clientes</h2>

    <!-- sirve para buscar usuarios en la tabla mientras escribís -->
        <div class="search-container">
            <input type="text" id="userSearchInput" placeholder="Buscar usuario..." class="search-input">
        </div>

        <table id="userTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Roles</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                 // Sirve para conectarse a la base de datos
                    $db = new Database();
                    $db->connectDatabase();

                    // Creo el modelo de usuarios usando la conexión a la base de datos
                    $userModel = new UserModel($db->getConnection());
                    // Recupero la lista completa de clientes
                    $clientes = $userModel->getAllClientes();

                    if ($clientes) {
                    // Muestra los datos de cada cliente en la tabla
                        foreach ($clientes as $cliente) {
                            $role = htmlspecialchars($cliente['role']);

                            echo "<tr class='row-role-$role'>";
                            echo "<td>{$cliente['id']}</td>";
                            echo "<td>{$cliente['name']}</td>";
                            echo "<td>{$cliente['email']}</td>";
                            echo "<td><span class='role $role'>$role</span></td>";
                            echo "<td><span class='created-at'>🕒 " . htmlspecialchars($cliente['created_at']) . "</span></td>";

                            // Botones para editar o borrar ese cliente
                            echo "<td>
                                    <a href='/ProyectoPandora/Public/index.php?route=Admin/Edit-user&id={$cliente['id']}' class='btn edit-btn'>Editar</a>
                                    <a href='/ProyectoPandora/Public/index.php?route=Admin/Delete-user&id={$cliente['id']}' class='btn delete-btn'>Eliminar</a>
                                </td>";
                            echo "</tr>";
                        }
                    } else {
                        // Si no hay clientes, aviso con este mensaje
                        echo "<tr><td colspan='6'>No hay clientes registrados.</td></tr>";
                    }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Botón para cambiar entre modo claro y oscuro -->
    <div class="dark-mode-btn" id="dark-mode-btn">
        <i class='bx bx-sun'></i> 
        <i class='bx bx-moon'></i> 
    </div>
</main>

<script>
// Filtra los resultados de la tabla mientras escribís en el buscador
    document.addEventListener("DOMContentLoaded", function() {
        const input = document.getElementById("userSearchInput");

        // Al escribir en el campo de búsqueda, filtra las filas de la tabla
        input.addEventListener("input", function() {
            const searchTerm = input.value.toLowerCase();
            const rows = document.querySelectorAll("#userTable tbody tr");

            rows.forEach(row => {
                const rowText = row.textContent.toLowerCase();
                // Muestra la fila solo si coincide con lo que se busca
                row.style.display = rowText.includes(searchTerm) ? "" : "none";
            });
        });

        // Cambio el tema a oscuro o claro al hacer clic en el botón
        const darkModeBtn = document.getElementById("dark-mode-btn");
        darkModeBtn.addEventListener("click", () => {
            document.body.classList.toggle("dark-mode");
        });
    });
</script>
