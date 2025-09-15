<?php include_once __DIR__ . '/../Includes/Sidebar.php'; ?>

<?php
// Verificamos el rol logueado desde la sesión
$rol = $_SESSION['user']['role'] ?? null;

switch ($rol) {
    case 'Administrador':
        include_once __DIR__ . '/../Admin/PanelAdmin.php';
        break;
    case 'Tecnico':
        include_once __DIR__ . '/../Paneles/PanelTecnico.php';
        break;
    case 'Supervisor':
        include_once __DIR__ . '/../Paneles/PanelSupervisor.php';
        break;
    default:
        echo "<p>No tienes un rol asignado o el rol no es válido.</p>";
        break;
}
?>

<main>
    <div class="Tabla-Contenedor">
        <h2>Lista de Inventario</h2>
        <div class="botones">
            <div class="btn-table-acciones">
                <a class="btn-acciones-inventario-cate" href="/ProyectoPandora/Public/index.php?route=Inventario/MostrarCrearItem">Añadir Item</a>
            </div>
        </div>
        <table id="inventarioTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Categoría</th>
                    <th>Nombre</th>
                    <th>Valor Unitario</th>
                    <th>Descripción</th>
                    <th>Imagen</th>
                    <th>Stock Actual</th>
                    <th>Stock Mínimo</th>
                    <th>Fecha Creación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($items)) {
                    foreach ($items as $item) {
                        echo "<tr>";
                        echo "<td>{$item['id']}</td>";
                        echo "<td>{$item['categoria']}</td>";
                        echo "<td>{$item['name_item']}</td>";
                        echo "<td>{$item['valor_unitario']}</td>";
                        echo "<td>{$item['descripcion']}</td>";
                        echo "<td>";
                        if (!empty($item['foto_item'])) {
                            echo "<img src='/ProyectoPandora/Public/img/imgInventario/{$item['foto_item']}' width='80'>";
                        } else {
                            echo "Sin imagen";
                        }
                        echo "</td>";
                        echo "<td>{$item['stock_actual']}</td>";
                        echo "<td>{$item['stock_minimo']}</td>";
                        echo "<td>{$item['fecha_creacion']}</td>";
                        echo "<td>
                                <div class='action-buttons'>
                                    <!-- Puedes agregar aquí editar si lo implementas -->
                                    <a href='/ProyectoPandora/Public/index.php?route=Inventario/Eliminar&id={$item['id']}' class='btn delete-btn' onclick=\"return confirm('¿Seguro que deseas eliminar este item?');\">Eliminar</a>
                                </div>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='10'>No hay items en el inventario.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</main>
<?php include_once __DIR__ . '/../Includes/Footer.php' ?>