 <div class="Tabla-Contenedor">
     <h2>Clientes</h2>
     <div class="search-container">
         <input type="text" id="userSearchInput" placeholder="Buscar usuario..." class="search-input">
     </div>
     <table>
         <thead>
             <tr>
                 <th>ID</th>
                 <th>Nombre</th>
                 <th>Email</th>
                 <th>Roles</th>
                 <th>Teléfono</th>
                 <th>Dirección</th>
                 <th>Fecha</th>
                 <th>Acciones</th>
             </tr>
         </thead>
         <tbody>
             <?php
                $db = new Database();
                $db->connectDatabase();
                $userModel = new UserModel($db->getConnection());
                $clientes = $userModel->getAllClientes();
                if ($clientes) {
                    foreach ($clientes as $cliente) {
                        echo "<tr>";
                        echo "<td>{$cliente['id']}</td>";
                        echo "<td>{$cliente['name']}</td>";
                        echo "<td>{$cliente['email']}</td>";
                        $role = htmlspecialchars($cliente['role']);
                        echo "<td><span class='role $role'>$role</span></td>";
                        echo "<td>{$cliente['telefono']}</td>";
                        echo "<td>{$cliente['direccion']}</td>";
                        echo "<td><span class='created-at'>🕒 " . htmlspecialchars($cliente['created_at']) . "</span></td>";
                        echo "<td><a href='/ProyectoPandora/Public/index.php?route=Admin/Edit-user&id={$cliente['id']}' class='btn edit-btn'>Editar</a>
                          <a href='/ProyectoPandora/Public/index.php?route=Admin/Delete-user&id={$cliente['id']}' class='btn delete-btn'>Eliminar</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No hay clientes registrados.</td></tr>";
                }
                ?>
         </tbody>
     </table>
 </div>
 <script>
     document.addEventListener("DOMContentLoaded", function() {
         const input = document.getElementById("userSearchInput");
         input.addEventListener("input", function() {
             const searchTerm = input.value.toLowerCase();
             const rows = document.querySelectorAll("#userTable tbody tr");
             rows.forEach(row => {
                 const rowText = row.textContent.toLowerCase();
                 row.style.display = rowText.includes(searchTerm) ? "" : "none";
             });
         });
     });
 </script>