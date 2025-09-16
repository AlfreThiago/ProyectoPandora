<?php 
require_once __DIR__ . '/../Core/Database.php';
require_once __DIR__ . '/../Core/Auth.php';
require_once __DIR__ . '/../Models/Inventario.php';
require_once __DIR__ . '/HistorialController.php';
require_once __DIR__ . '/../Models/Category.php';

class InventarioController
{
    private $categoryModel;
    private $inventarioModel;
    private $historialController;

    public function __construct()
    {
        $db = new Database();
        $db->connectDatabase();
        $this->inventarioModel = new InventarioModel($db->getConnection());
        $this->categoryModel = new CategoryModel($db->getConnection());
        $this->historialController = new HistorialController();
    }

    public function listarInventario()
    {
        Auth::checkRole(['Administrador', 'Supervisor', 'Tecnico']);
        $items = $this->inventarioModel->listar();
        include_once __DIR__ . '/../Views/Inventario/InventarioLista.php';
    }

    public function mostrarCrear()
    {
        Auth::checkRole(['Administrador', 'Supervisor']);
        $categorias = $this->inventarioModel->listarCategorias();
        include_once __DIR__ . '/../Views/Inventario/CrearItem.php';
    }

    public function crear()
    {
        Auth::checkRole(['Administrador', 'Supervisor']);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $categoria_id = $_POST['categoria_id'] ?? null;
            $name_item = $_POST['name_item'] ?? '';
            $valor_unitario = $_POST['valor_unitario'] ?? 0;
            $descripcion = $_POST['descripcion'] ?? '';
            $stock_actual = $_POST['stock_actual'] ?? 0;
            $stock_minimo = $_POST['stock_minimo'] ?? 0;
            $foto_item = null;

            // Manejo de imagen
            if (isset($_FILES['foto_item']) && $_FILES['foto_item']['error'] === UPLOAD_ERR_OK) {
                $foto_item = $_FILES['foto_item']['name'];
                $destino = __DIR__ . '/../Public/img/imgInventario/' . $foto_item;
                move_uploaded_file($_FILES['foto_item']['tmp_name'], $destino);
            }

            if ($this->inventarioModel->crear($categoria_id, $name_item, $valor_unitario, $descripcion, $foto_item, $stock_actual, $stock_minimo)) {
                $user = Auth::user();
                $this->historialController->agregarAccion(
                    "Alta inventario",
                    "El usuario {$user['name']} agregó el item '$name_item' al inventario."
                );
                header('Location: /ProyectoPandora/Public/index.php?route=Inventario/ListarItem&success=1');
                exit;
            } else {
                header('Location: /ProyectoPandora/Public/index.php?route=Inventario/CrearItem&error=1');
                exit;
            }
        }
        $this->mostrarCrear();
    }

    public function eliminar()
    {
        Auth::checkRole(['Administrador', 'Supervisor']);
        $id = $_GET['id'] ?? null;
        if ($id && $this->inventarioModel->eliminar($id)) {
            $user = Auth::user();
            $this->historialController->agregarAccion(
                "Baja inventario",
                "El usuario {$user['name']} eliminó el item con ID $id del inventario."
            );
            header('Location: /ProyectoPandora/Public/index.php?route=Inventario/ListarItem&success=1');
            exit;
        } else {
            header('Location: /ProyectoPandora/Public/index.php?route=Inventario/ListarItem&error=1');
            exit;
        }
    }

    public function mostrarActualizar()
    {
        Auth::checkRole(['Administrador', 'Supervisor']);
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /ProyectoPandora/Public/index.php?route=Inventario/ListarItem&error=1');
            exit;
        }
        $item = $this->inventarioModel->obtenerPorId($id);
        $categorias = $this->inventarioModel->listarCategorias();
        include_once __DIR__ . '/../Views/Inventario/ActualizarItem.php';
    }

    public function editar()
    {
        Auth::checkRole(['Administrador', 'Supervisor']);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $categoria_id = $_POST['categoria_id'] ?? null;
            $name_item = $_POST['name_item'] ?? '';
            $valor_unitario = $_POST['valor_unitario'] ?? 0;
            $descripcion = $_POST['descripcion'] ?? '';
            $stock_actual = $_POST['stock_actual'] ?? 0;
            $stock_minimo = $_POST['stock_minimo'] ?? 0;
            $foto_item = $_POST['foto_item_actual'] ?? null;

            // Manejo de imagen nueva
            if (isset($_FILES['foto_item']) && $_FILES['foto_item']['error'] === UPLOAD_ERR_OK) {
                $foto_item = $_FILES['foto_item']['name'];
                $destino = __DIR__ . '/../Public/img/imgInventario/' . $foto_item;
                move_uploaded_file($_FILES['foto_item']['tmp_name'], $destino);
            }

            if ($this->inventarioModel->actualizar($id, $categoria_id, $name_item, $valor_unitario, $descripcion, $foto_item, $stock_actual, $stock_minimo)) {
                $user = Auth::user();
                $this->historialController->agregarAccion(
                    "Edición inventario",
                    "El usuario {$user['name']} editó el item '$name_item' (ID $id) del inventario."
                );
                header('Location: /ProyectoPandora/Public/index.php?route=Inventario/ListarItem&success=1');
                exit;
            } else {
                header('Location: /ProyectoPandora/Public/index.php?route=Inventario/ActualizarItem&id=' . $id . '&error=1');
                exit;
            }
        }
        $this->mostrarActualizar();
    }
    
    public function listarCategorias()
    {
        Auth::checkRole(['Administrador', 'Supervisor']);
        $categorias = $this->inventarioModel->listarCategorias();
        include_once __DIR__ . '/../Views/Inventario/ListaCategoria.php';
    }

    public function mostrarCrearCategoria()
    {
        Auth::checkRole(['Administrador', 'Supervisor']);
        include_once __DIR__ . '/../Views/Inventario/CrearCategoria.php';
    }

    public function crearCategoria()
    {
        Auth::checkRole(['Administrador', 'Supervisor']);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            if ($this->categoryModel->crearInventarioCategory($name)) {
                $user = Auth::user();
                $accion = "Creación de categoría de inventario";
                $detalle = "Usuario {$user['name']} creó la categoría '{$name}'";
                $this->historialController->agregarAccion($accion, $detalle);

                header('Location: /ProyectoPandora/Public/index.php?route=Inventario/ListarCategorias&success=1');
                exit;
            } else {
                header('Location: /ProyectoPandora/Public/index.php?route=Inventario/CrearCategoria&error=1');
                exit;
            }
        }
        $this->mostrarCrearCategoria();
    }

    public function eliminarCategoriaInventario()
    {
        Auth::checkRole(['Administrador', 'Supervisor']);
        $id = $_GET['id'] ?? null;
        if ($id && $this->categoryModel->eliminarCategory($id)) {
            $user = Auth::user();
            $accion = "Eliminación de categoría de inventario";
            $detalle = "Usuario {$user['name']} eliminó la categoría ID {$id}";
            $this->historialController->agregarAccion($accion, $detalle);

            header('Location: /ProyectoPandora/Public/index.php?route=Inventario/ListarCategorias&success=1');
            exit;
        } else {
            header('Location: /ProyectoPandora/Public/index.php?route=Inventario/ListarCategorias&error=1');
            exit;
        }
    }
}

?>
