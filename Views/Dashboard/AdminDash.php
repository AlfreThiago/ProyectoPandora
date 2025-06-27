<?php
include_once __DIR__ . '/../Shared/AdminHeader.php';
?>

<body>
    <?php if ($_SESSION['user']['role'] === 'Administrador'): ?>
        <h3>Cambiar rol de usuario</h3>
        <form action="/ProyectoPandora/Public/index.php?route=Admin/change-role" method="POST">
            <label for="user_id">ID de usuario:</label>
            <input type="number" name="user_id" id="user_id" required>

            <label for="newRole">Nuevo rol:</label>
            <select name="newRole" id="newRole" required>
                <option value="Administrador">Administrador</option>
                <option value="Supervisor">Supervisor</option>
                <option value="Tecnico">Tecnico</option>
                <option value="Cliente">Cliente</option>
            </select>

            <button type="submit" name="change_role">Cambiar rol</button>
            <div class="table-conteiner">

                <table>
                    <tr>
                        <td>Nombre</td>
                        <td>Correo</td>
                        <td>Rol</td>
                        <td>Tiempo de Creacion</td>
                    </tr>
            </table>
                </div>
        </form>
    <?php endif; ?>
</body>