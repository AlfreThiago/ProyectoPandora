<?php
include_once __DIR__ . '/../Shared/AdminHeader.php';
include_once __DIR__ . '/../../Core/Database.php'
?>

<body>
    <div class="table-conteiner">

        <table>
            <tr>
                <td>ID</td>
                <td>Nombre</td>
                <td>Correo</td>
                <td>Rol</td>
                <td>Tiempo de Creacion</td>
                <td>Acciones</td>
            </tr>
            <?php
            $db = new Database();
            $db->conectDatabase();
            $userModel = new UserModel($db->getConnection());
            $users = $userModel->getAllUsers();
            if ($users) {
                foreach ($users as $user) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($user['id']) . "</td>";
                    echo "<td>" . htmlspecialchars($user['name']) . "</td>";
                    echo "<td>" . htmlspecialchars($user['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($user['role']) . "</td>";
                    echo "<td>" . htmlspecialchars($user['created_at']) . "</td>";
                    echo "<td>";
                    echo "<a href='/ProyectoPandora/Public/index.php?route=Admin/Edit-user&id=" . htmlspecialchars($user['id']) . "'>Editar</a> | ";
                    echo "<a href='/ProyectoPandora/Public/index.php?route=Admin/Delete-user&id=" . htmlspecialchars($user['id']) . "'>Eliminar</a>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td> No hay usuarios registrados.</td></tr>";
            }
            ?>
        </table>
    </div>
    </form>
</body>