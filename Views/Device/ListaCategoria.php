<?php include_once __DIR__ . '/../Includes/Sidebar.php' ?>
<?php include_once __DIR__ . '/../Admin/PanelAdmin.php' ?>
<main>
    <div class="Tabla-Contenedor">
        <h2>Lista de Categorías</h2>
        <div class="search-container">
            <input type="text" id="categorySearchInput" placeholder="Buscar categoría..." class="search-input">
        </div>
        <div class="botones">
            <div class="dropdown">
                <label for="menu-toggle" class="dropdown-label" >
                    Opciones<i class='bxr  bx-caret-down'  ></i> </label>
                <input type="checkbox" id="menu-toggle" />
            
                <div class="dropdown-menu">
                    <a class="btn-table" href="/ProyectoPandora/Public/index.php?route=Device/ListarDevice">Dispositivos</a>
                    <a class="btn-table" href="/ProyectoPandora/Public/index.php?route=Device/ListarCategoria">Categorias</a>
                </div>
                
            </div>
            <div class="btn-table-acciones">
                <a class="btn-acciones-device" href="/ProyectoPandora/Public/index.php?route=Device/CrearCategoria">Añadir Categoria</a>
            </div>
        </div>
        <table id="categoryTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre de la Categoría</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categorias as $categoria): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($categoria['id']); ?></td>
                        <td><?php echo htmlspecialchars($categoria['name']); ?></td>
                        <td>
                            <div class='action-buttons'>
                                <a href="/ProyectoPandora/Public/index.php?route=Device/ActualizarCategoria&id=<?php echo $categoria['id']; ?>" class="btn edit-btn">Actualizar</a>
                                |
                                <a href="/ProyectoPandora/Public/index.php?route=Device/Delete-Category&id=<?php echo $categoria['id']; ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar esta categoría?');" class="btn delete-btn">Eliminar</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($categorias)): ?>
                    <tr>
                        <td colspan="3">No hay categorías disponibles.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="dark-mode-btn" id="dark-mode-btn">
        <i class='bx bx-sun'></i>
        <i class='bx bx-moon'></i>
    </div>
    <script src="/ProyectoPandora/Public/js/Buscador.js"></script>
</main>
<?php include_once __DIR__ . '/../Includes/Footer.php' ?>