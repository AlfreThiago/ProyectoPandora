 <div class="Tabla-Contenedor">
     <h2>Tecnicos</h2>
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
                 <th>Disponibilidad</th>
                 <th>Especializacion</th>
                 <th>Fecha</th>
                 <th>Acciones</th>
             </tr>
         </thead>
         <tbody>
             <?php
                $db = new Database();
                $db->connectDatabase();
                $userModel = new UserModel($db->getConnection());
                $Tecnicos = $userModel->getAllTecnicos();
                if ($Tecnicos) {
                    foreach ($Tecnicos as $tec) {
                        echo "<tr>";
                        echo "<td>{$tec['id']}</td>";
                        echo "<td>{$tec['name']}</td>";
                        echo "<td>{$tec['email']}</td>";
                        $role = htmlspecialchars($tec['role']);
                        echo "<td><span class='role $role'>$role</span></td>";
                        echo "<td>{$tec['disponibilidad']}</td>";
                        echo "<td>{$tec['especialidad']}</td>";
                        echo "<td><span class='created-at'>🕒 " . htmlspecialchars($tec['created_at']) . "</span></td>";
                        echo "<td><a href='/ProyectoPandora/Public/index.php?route=Admin/Edit-user&id={$tec['id']}' class='btn edit-btn'>Editar</a>
                          <a href='/ProyectoPandora/Public/index.php?route=Admin/Delete-user&id={$tec['id']}' class='btn delete-btn'>Eliminar</a></td>";
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