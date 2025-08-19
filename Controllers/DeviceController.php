<?php
require_once __DIR__ . '/../Core/Database.php';
require_once __DIR__ . '/../Models/Device.php';
require_once __DIR__ . '/../Models/Category.php';
require_once __DIR__ . '/../Controllers/HistorialController.php';
require_once __DIR__ . '/../Core/Auth.php';


class DeviceController
{
    private $historialController;
    private $deviceModel;
    private $categoryModel;

    public function __construct()
    {
        $this->historialController = new HistorialController();
        $db = new Database();
        $db->connectDatabase();
        $this->deviceModel = new DeviceModel($db->getConnection());
        $this->categoryModel = new CategoryModel($db->getConnection());
    }
    public function listarDevice()
    {
        $user = Auth::user();
        if (!$user) {
            header('Location: /ProyectoPandora/Public/index.php?route=Auth/Login');
            exit;
        }
        $dispositivos = $this->deviceModel->getAllDevices();
        include_once __DIR__ . '/../Views/Device/ListaDispositivos.php';
    }

    public function listarCategoria()
    {
        $user = Auth::user();
        if (!$user) {
            header('Location: /ProyectoPandora/Public/index.php?route=Auth/Login');
            exit;
        }
        $categorias = $this->categoryModel->getAllCategories();
        include_once __DIR__ . '/../Views/Device/ListaCategoria.php';
    }

    public function AgregarDispositivo()
    {
        $user = Auth::user();
        if (!$user) {
            header('Location: /ProyectoPandora/Public/index.php?route=Auth/Login');
            exit;
        }
        $userId = $user['id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $categoriaId = $_POST['categoria_id'] ?? 0;
            $marca = $_POST['marca'] ?? '';
            $modelo = $_POST['modelo'] ?? '';
            $descripcion = $_POST['descripcion_falla'] ?? '';
            $img_dispositivo = $_FILES['img_dispositivo']['name'] ?? '';

            if (!$categoriaId || !$marca || !$modelo || !$img_dispositivo) {
                echo "Todos los campos son obligatorios.";
                return;
            }

            $rutaDestino = __DIR__ . '/../Public/img/imgDispositivos/' . $img_dispositivo;
            if (!move_uploaded_file($_FILES['img_dispositivo']['tmp_name'], $rutaDestino)) {
                echo "Error al subir la imagen.";
                return;
            }

            $db = new Database();
            $db->connectDatabase();
            $deviceModel = new DeviceModel($db->getConnection());

            if ($deviceModel->createDevice($userId, $categoriaId, $marca, $modelo, $descripcion, $img_dispositivo)) {
                $accion = "Agregar dispositivo";
                $detalle = "Usuario {$user['name']} agregó el dispositivo {$marca} {$modelo}";
                $this->historialController->agregarAccion($accion, $detalle);

                header('Location: /ProyectoPandora/Public/index.php?route=Dash/Device&success=1');
                exit;
            } else {
                echo "Error al registrar el dispositivo.";
            }
        }
    }
    public function CrearCategoria()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombreCategoria = $_POST['nombre'] ?? '';
            if (empty($nombreCategoria)) {
                header('Location: /ProyectoPandora/Public/index.php?route=Dash/Device&error=CamposRequeridos');
                exit;
            }
            $db = new Database();
            $db->connectDatabase();
            $categoryModel = new categoryModel($db->getConnection());
            if ($categoryModel->createCategory($nombreCategoria)) {
                header('Location: /ProyectoPandora/Public/index.php?route=Dash/CrearCategoriaDevice&success=1');
                exit;
            }
            header('Location: /ProyectoPandora/Public/index.php?route=Dash/Device&error=ErrorAlAgregarCategoria');
            exit;
        } else {
            header('Location: /ProyectoPandora/Public/index.php?route=Dash/CrearCategoriaDevice');
        }
    }
    public function EditCategory()
    {
        $categoryId = $_GET['id'] ?? 0;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombreCategoria = $_POST['nombre'] ?? '';
            if (empty($nombreCategoria)) {
                header('Location: /ProyectoPandora/Public/index.php?route=Device/ListaCategoria&error=CamposRequeridos');
                exit;
            }
            $db = new Database();
            $db->connectDatabase();
            $categoryModel = new CategoryModel($db->getConnection());
            if ($categoryModel->updateCategory($categoryId, $nombreCategoria)) {
                header('Location: /ProyectoPandora/Public/index.php?route=Device/ListaCategoria&success=1');
                exit;
            }
            header('Location: /ProyectoPandora/Public/index.php?route=Device/ListaCategoria&error=ErrorAlActualizarCategoria');
            exit;
        }
        $db = new Database();
        $db->connectDatabase();
        $categoryModel = new CategoryModel($db->getConnection());
        $categoria = $categoryModel->getCategoryById($categoryId);
        if (!$categoria) {
            header('Location: /ProyectoPandora/Public/index.php?route=Device/ListaCategoria&error=CategoriaNoEncontrada');
            exit;
        }
        require_once __DIR__ . '/../Views/Device/EditCategory.php';
    }
    public function ActualizarDevice()
    {
        $user = Auth::user();
        if (!$user) {
            header('Location: /ProyectoPandora/Public/index.php?route=Auth/Login');
            exit;
        }
        $deviceId = $_GET['id'] ?? 0;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $categoriaId = $_POST['categoria_id'] ?? 0;
            $marca = $_POST['marca'] ?? '';
            $modelo = $_POST['modelo'] ?? '';
            $descripcion = $_POST['descripcion_falla'] ?? '';
            $img_dispositivo = $_FILES['img_dispositivo']['name'] ?? '';
            $rutaDestino = __DIR__ . '/../Public/img/imgDispositivos/' . $img_dispositivo;

            if (!$categoriaId || !$marca || !$modelo || !$img_dispositivo) {
                echo "Todos los campos son obligatorios.";
                return;
            }
            if (!move_uploaded_file($_FILES['img_dispositivo']['tmp_name'], $rutaDestino)) {
                echo "Error al subir la imagen.";
                return;
            }
            $db = new Database();
            $db->connectDatabase();
            $deviceModel = new DeviceModel($db->getConnection());
            if ($deviceModel->updateDevice($deviceId, $categoriaId, $marca, $modelo, $descripcion, $img_dispositivo)) {
                $accion = "Editar dispositivo";
                $detalle = "Usuario {$user['name']} editó el dispositivo {$marca} {$modelo} (ID: $deviceId)";
                $this->historialController->agregarAccion($accion, $detalle);

                header('Location: index.php?route=Device/ListarDevice');
                exit;
            }
            echo "Error al actualizar el dispositivo.";
        } else {
            include_once __DIR__ . '/../Views/Device/ActualizarDevice.php';
        }
    }
    public function DeleteDevice()
    {
        $user = Auth::user();
        if (!$user) {
            header('Location: /ProyectoPandora/Public/index.php?route=Auth/Login');
            exit;
        }
        $deviceId = $_GET['id'] ?? 0;
        if (!$deviceId) {
            header('Location: /ProyectoPandora/Public/index.php?route=Device/ListarDevice&error=DeviceNotFound');
            exit;
        }
        $db = new Database();
        $db->connectDatabase();
        $deviceModel = new DeviceModel($db->getConnection());
        if ($deviceModel->deleteDevice($deviceId)) {
            // Guardar en historial
            $accion = "Eliminar dispositivo";
            $detalle = "Usuario {$user['name']} eliminó el dispositivo con ID: $deviceId";
            $this->historialController->agregarAccion($accion, $detalle);

            header('Location: /ProyectoPandora/Public/index.php?route=Device/ListarDevice&success=1');
            exit;
        }
        header('Location: /ProyectoPandora/Public/index.php?route=Device/ListarDevice&error=ErrorDeletingDevice');
        exit;
    }
    public function deleteCategory()
    {
        $categoryId = $_GET['id'] ?? 0;
        if (!$categoryId) {
            header('Location: /ProyectoPandora/Public/index.php?route=Device/ListarCategoria&error=CategoryNotFound');
            exit;
        }
        $db = new Database();
        $db->connectDatabase();
        $categoryModel = new CategoryModel($db->getConnection());
        if ($categoryModel->deleteCategory($categoryId)) {
            header('Location: /ProyectoPandora/Public/index.php?route=Device/ListarCategoria&success=1');
            exit;
        }
        header('Location: /ProyectoPandora/Public/index.php?route=Device/ListarCategoria&error=ErrorDeletingCategory');
        exit;
    }
}
