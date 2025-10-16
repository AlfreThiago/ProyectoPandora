<?php 
require_once __DIR__ . '/../Core/Database.php';
require_once __DIR__ . '/../Core/Auth.php';
require_once __DIR__ . '/../Models/Inventario.php';
require_once __DIR__ . '/HistorialController.php';
require_once __DIR__ . '/../Models/InventoryCategory.php';

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
    $this->categoryModel = new InventoryCategoryModel($db->getConnection());
        $this->historialController = new HistorialController();
    }

    public function listarInventario()
    {
        // Ruta legacy: no existe vista Inventario/InventarioLista.
        // Redirigimos al panel vigente de gestión para mantener compatibilidad.
        Auth::checkRole(['Supervisor', 'Tecnico']);
        header('Location: /ProyectoPandora/Public/index.php?route=Supervisor/GestionInventario');
        exit;
    }

    public function mostrarCrear()
    {
        
        Auth::checkRole(['Supervisor']);
        $categorias = $this->inventarioModel->listarCategorias();
        include_once __DIR__ . '/../Views/Inventario/CrearItem.php';
    }

    public function crear()
    {
        
        Auth::checkRole(['Supervisor']);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $categoria_id = $_POST['categoria_id'] ?? null;
            $name_item = $_POST['name_item'] ?? '';
            $valor_unitario = $_POST['valor_unitario'] ?? 0;
            $descripcion = $_POST['descripcion'] ?? '';
            $stock_actual = $_POST['stock_actual'] ?? 0;
            $stock_minimo = $_POST['stock_minimo'] ?? 0;
            $foto_item = null;

            
            if (isset($_FILES['foto_item']) && $_FILES['foto_item']['error'] === UPLOAD_ERR_OK) {
                $foto_item = $_FILES['foto_item']['name'];
                $destino = __DIR__ . '/../Public/img/imgInventario/' . $foto_item;
                move_uploaded_file($_FILES['foto_item']['tmp_name'], $destino);
            }

            
            $existente = $this->inventarioModel->findByCategoryAndName((int)$categoria_id, $name_item);
            if ($existente) {
                $ok = $this->inventarioModel->sumarStock((int)$existente['id'], (int)$stock_actual);
            } else {
                $ok = $this->inventarioModel->crear($categoria_id, $name_item, $valor_unitario, $descripcion, $foto_item, $stock_actual, $stock_minimo);
            }

            if ($ok) {
                $user = Auth::user();
                $accion = $existente ? "Ingreso de stock" : "Alta inventario";
                $detalle = $existente
                    ? "El usuario {$user['name']} sumó {$stock_actual} al item '{$name_item}' (ID {$existente['id']})."
                    : "El usuario {$user['name']} creó el item '{$name_item}' con stock {$stock_actual} (mínimo {$stock_minimo}).";
                $this->historialController->agregarAccion($accion, $detalle);
                header('Location: /ProyectoPandora/Public/index.php?route=Supervisor/GestionInventario&success=1');
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
        
        Auth::checkRole(['Supervisor']);
        $id = $_GET['id'] ?? null;
        if ($id && $this->inventarioModel->eliminar($id)) {
            $user = Auth::user();
            $this->historialController->agregarAccion(
                "Baja inventario",
                "El usuario {$user['name']} eliminó el item con ID $id del inventario."
            );
            header('Location: /ProyectoPandora/Public/index.php?route=Supervisor/GestionInventario&success=1');
            exit;
        } else {
            header('Location: /ProyectoPandora/Public/index.php?route=Supervisor/GestionInventario&error=1');
            exit;
        }
    }

    public function mostrarActualizar()
    {
        
        Auth::checkRole(['Supervisor']);
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /ProyectoPandora/Public/index.php?route=Supervisor/GestionInventario&error=1');
            exit;
        }
    $item = $this->inventarioModel->obtenerPorId($id);
    $categorias = $this->inventarioModel->listarCategorias();
    // Vista de actualización de item no existe; redirigimos al panel de gestión con foco por id.
    header('Location: /ProyectoPandora/Public/index.php?route=Supervisor/GestionInventario&id=' . urlencode((string)$id));
    exit;
    }

    public function editar()
    {
        
        Auth::checkRole(['Supervisor']);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $categoria_id = $_POST['categoria_id'] ?? null;
            $name_item = $_POST['name_item'] ?? '';
            $valor_unitario = $_POST['valor_unitario'] ?? 0;
            $descripcion = $_POST['descripcion'] ?? '';
            $stock_actual = $_POST['stock_actual'] ?? 0;
            $stock_minimo = $_POST['stock_minimo'] ?? 0;
            $foto_item = $_POST['foto_item_actual'] ?? null;

            
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
                header('Location: /ProyectoPandora/Public/index.php?route=Supervisor/GestionInventario&success=1');
                exit;
            } else {
                header('Location: /ProyectoPandora/Public/index.php?route=Supervisor/GestionInventario&error=1');
                exit;
            }
        }
    // No hay vista dedicada; regresar al panel.
    header('Location: /ProyectoPandora/Public/index.php?route=Supervisor/GestionInventario');
    exit;
    }

    public function sumarStock()
    {
        
        Auth::checkRole(['Supervisor']);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int)($_POST['id'] ?? 0);
            $cantidad = (int)($_POST['cantidad'] ?? 0);
            if ($id > 0 && $cantidad > 0) {
                if ($this->inventarioModel->sumarStock($id, $cantidad)) {
                    $user = Auth::user();
                    $this->historialController->agregarAccion(
                        'Ingreso de stock',
                        "Usuario {$user['name']} sumó {$cantidad} unidades al item ID {$id}."
                    );
                    header('Location: /ProyectoPandora/Public/index.php?route=Supervisor/GestionInventario&success=1');
                    exit;
                }
            }
        }
        header('Location: /ProyectoPandora/Public/index.php?route=Supervisor/GestionInventario&error=1');
        exit;
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
            if ($this->categoryModel->createCategory($name)) {
                $user = Auth::user();
                $accion = "Creación de categoría de inventario";
                $detalle = "Usuario {$user['name']} creó la categoría '{$name}'";
                $this->historialController->agregarAccion($accion, $detalle);
                
                if (($user['role'] ?? '') === 'Supervisor') {
                    header('Location: /ProyectoPandora/Public/index.php?route=Supervisor/GestionInventario&success=1');
                } else {
                    header('Location: /ProyectoPandora/Public/index.php?route=Inventario/ListarCategorias&success=1');
                }
                exit;
            } else {
                $user = Auth::user();
                if (($user['role'] ?? '') === 'Supervisor') {
                    header('Location: /ProyectoPandora/Public/index.php?route=Supervisor/GestionInventario&error=1');
                } else {
                    header('Location: /ProyectoPandora/Public/index.php?route=Inventario/ListarCategorias&error=1');
                }
                exit;
            }
        }
        $this->mostrarCrearCategoria();
    }

    public function eliminarCategoriaInventario()
    {
        
        Auth::checkRole(['Administrador', 'Supervisor']);
        $id = $_GET['id'] ?? null;
    if ($id && $this->categoryModel->deleteCategory((int)$id)) {
            $user = Auth::user();
            $accion = "Eliminación de categoría de inventario";
            $detalle = "Usuario {$user['name']} eliminó la categoría ID {$id}";
            $this->historialController->agregarAccion($accion, $detalle);
            if (($user['role'] ?? '') === 'Supervisor') {
                header('Location: /ProyectoPandora/Public/index.php?route=Supervisor/GestionInventario&success=1');
            } else {
                header('Location: /ProyectoPandora/Public/index.php?route=Inventario/ListarCategorias&success=1');
            }
            exit;
        } else {
            $user = Auth::user();
            if (($user['role'] ?? '') === 'Supervisor') {
                header('Location: /ProyectoPandora/Public/index.php?route=Supervisor/GestionInventario&error=1');
            } else {
                header('Location: /ProyectoPandora/Public/index.php?route=Inventario/ListarCategorias&error=1');
            }
            exit;
        }
    }

    
    public function mostrarActualizarCategoria()
    {
        
        Auth::checkRole(['Administrador', 'Supervisor']);
        $id = $_GET['id'] ?? null;
        if (!$id) {
            $user = Auth::user();
            $dest = (($user['role'] ?? '') === 'Supervisor')
                ? '/ProyectoPandora/Public/index.php?route=Supervisor/GestionInventario&error=1'
                : '/ProyectoPandora/Public/index.php?route=Inventario/ListarCategorias&error=1';
            header('Location: ' . $dest);
            exit;
        }
        $user = Auth::user();
        $backUrl = (($user['role'] ?? '') === 'Supervisor')
            ? '/ProyectoPandora/Public/index.php?route=Supervisor/GestionInventario'
            : '/ProyectoPandora/Public/index.php?route=Inventario/ListarCategorias';
        $categoria = $this->categoryModel->obtenerCategoryPorId($id);
        include_once __DIR__ . '/../Views/Inventario/ActualizarCategoria.php';
    }

    
    public function editarCategoria()
    {
        
        Auth::checkRole(['Administrador', 'Supervisor']);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $name = $_POST['name'] ?? '';
            if ($this->categoryModel->actualizarCategory($id, $name)) {
                $user = Auth::user();
                $accion = "Edición de categoría de inventario";
                $detalle = "Usuario {$user['name']} editó la categoría '{$name}' (ID {$id})";
                $this->historialController->agregarAccion($accion, $detalle);
                if (($user['role'] ?? '') === 'Supervisor') {
                    header('Location: /ProyectoPandora/Public/index.php?route=Supervisor/GestionInventario&success=1');
                } else {
                    header('Location: /ProyectoPandora/Public/index.php?route=Inventario/ListarCategorias&success=1');
                }
                exit;
            } else {
                $user = Auth::user();
                if (($user['role'] ?? '') === 'Supervisor') {
                    header('Location: /ProyectoPandora/Public/index.php?route=Supervisor/GestionInventario&error=1');
                } else {
                    header('Location: /ProyectoPandora/Public/index.php?route=Inventario/ListarCategorias&error=1');
                }
                exit;
            }
        }
        $this->mostrarActualizarCategoria();
    }

    
    public function actualizarCategoria()
    {
        
        Auth::checkRole(['Supervisor']);
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /ProyectoPandora/Public/index.php?route=Supervisor/GestionInventario&error=1');
            exit;
        }
    $item = $this->inventarioModel->obtenerPorId($id);
    $categorias = $this->inventarioModel->listarCategorias();
    header('Location: /ProyectoPandora/Public/index.php?route=Supervisor/GestionInventario&id=' . urlencode((string)$id));
    exit;
    }
}

?>