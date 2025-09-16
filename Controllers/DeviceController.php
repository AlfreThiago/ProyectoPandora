<?php
require_once __DIR__ . '/../Core/Database.php';
require_once __DIR__ . '/../Models/Device.php';
require_once __DIR__ . '/../Models/Category.php';
require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../Controllers/HistorialController.php';

class DeviceController
{
    private $historialController;
    private $deviceModel;
    private $categoryModel;
    private $userModel;

    public function __construct()
    {
        $db = new Database();
        $db->connectDatabase();
        $conn = $db->getConnection();

        $this->historialController = new HistorialController();
        $this->deviceModel = new DeviceModel($conn);
        $this->categoryModel = new CategoryModel($conn);
        $this->userModel = new UserModel($conn);
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

    public function mostrarCrearDispositivo()
    {
        $user = Auth::user();
        if (!$user) {
            header('Location: /ProyectoPandora/Public/index.php?route=Auth/Login');
            exit;
        }

        $isAdmin = ($user['role'] === 'Administrador');
        $clientes = [];
        if ($isAdmin) {
            $clientes = $this->userModel->getAllClientes();
        }
        $categorias = $this->categoryModel->getAllCategories();

        include_once __DIR__ . '/../Views/Device/CrearDevice.php';
    }

    public function CrearDispositivo()
    {
        $user = Auth::user();
        if (!$user) {
            header('Location: /ProyectoPandora/Public/index.php?route=Auth/Login');
            exit;
        }

        $isAdmin = ($user['role'] === 'Administrador');
        $clientes = [];
        if ($isAdmin) {
            $clientes = $this->userModel->getAllClientes();
        }
        $categorias = $this->categoryModel->getAllCategories();

        $userId = $isAdmin && isset($_POST['user_id']) ? $_POST['user_id'] : $user['id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $categoriaId = $_POST['categoria_id'] ?? 0;
            $marca = $_POST['marca'] ?? '';
            $modelo = $_POST['modelo'] ?? '';
            $descripcion = $_POST['descripcion_falla'] ?? '';
            $img_dispositivo = $_FILES['img_dispositivo']['name'] ?? '';

            if (!$categoriaId || !$marca || !$modelo || !$img_dispositivo) {
                $error = "Todos los campos son obligatorios.";
                include_once __DIR__ . '/../Views/Device/CrearDevice.php';
                return;
            }

            $rutaDestino = __DIR__ . '/../Public/img/imgDispositivos/' . $img_dispositivo;
            if (!move_uploaded_file($_FILES['img_dispositivo']['tmp_name'], $rutaDestino)) {
                $error = "Error al subir la imagen.";
                include_once __DIR__ . '/../Views/Device/CrearDevice.php';
                return;
            }

            if ($this->deviceModel->createDevice($userId, $categoriaId, $marca, $modelo, $descripcion, $img_dispositivo)) {
                $accion = "Agregar dispositivo";
                $detalle = "Usuario {$user['name']} agregó el dispositivo {$marca} {$modelo}";
                $this->historialController->agregarAccion($accion, $detalle);

                header('Location: /ProyectoPandora/Public/index.php?route=Device/ListarDevice&success=1');
                exit;
            } else {
                $error = "Error al registrar el dispositivo.";
                include_once __DIR__ . '/../Views/Device/CrearDevice.php';
                return;
            }
        }
        include_once __DIR__ . '/../Views/Device/CrearDevice.php';
    }

    public function CrearCategoria()
    {
        $user = Auth::user();
        if (!$user) {
            header('Location: /ProyectoPandora/Public/index.php?route=Auth/Login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombreCategoria = $_POST['nombre'] ?? '';

            if (empty($nombreCategoria)) {
                header('Location: /ProyectoPandora/Public/index.php?route=Device/CrearCategoria&error=CamposRequeridos');
                exit;
            }

            if ($this->categoryModel->createCategory($nombreCategoria)) {
                header('Location: /ProyectoPandora/Public/index.php?route=Device/ListarCategoria&success=1');
                exit;
            } else {
                header('Location: /ProyectoPandora/Public/index.php?route=Device/CrearCategoria&error=ErrorAlAgregarCategoria');
                exit;
            }
        }
        include_once __DIR__ . '/../Views/Device/CrearCategoria.php';
    }

    public function ActualizarCategoria()
    {
        $user = Auth::user();
        if (!$user) {
            header('Location: /ProyectoPandora/Public/index.php?route=Auth/Login');
            exit;
        }
        $id = (int) ($_GET['id'] ?? 0);

        $categoria = $this->categoryModel->findCategoryById($id);
        if (!$categoria) {
            echo "Categoría no encontrada.";
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombreCategoria = $_POST['nombre'] ?? '';
            if (empty($nombreCategoria)) {
                header('Location: /ProyectoPandora/Public/index.php?route=Device/ListarCategoria&error=CamposRequeridos');
                exit;
            }

            if ($this->categoryModel->updateCategory($id, $nombreCategoria)) {
                header('Location: /ProyectoPandora/Public/index.php?route=Device/ListarCategoria&success=1');
                exit;
            }

            header('Location: /ProyectoPandora/Public/index.php?route=Device/ListarCategoria&error=ErrorAlActualizarCategoria');
            exit;
        }
        require_once __DIR__ . '/../Views/Device/ActualizarCategoria.php';
    }

    public function ActualizarDevice()
    {
        Auth::checkRole(['Administrador', 'Supervisor', 'Tecnico', 'Cliente']);

        $id = $_GET['id'] ?? null;
        if (!$id || !is_numeric($id)) exit("ID inválido.");

        $dispositivo = $this->deviceModel->findDeviceById((int)$id);
        if (!$dispositivo) exit("Dispositivo no encontrado.");

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $categoria_id     = $_POST['categoria_id'] ?? null;
            $marca            = $_POST['marca'] ?? null;
            $modelo           = $_POST['modelo'] ?? null;
            $descripcion_falla = $_POST['descripcion_falla'] ?? null;

            if ($categoria_id && $marca && $modelo && $descripcion_falla) {
                $img_dispositivo = $dispositivo['img_dispositivo'];
                if (!empty($_FILES['img_dispositivo']['name'])) {
                    $dir = __DIR__ . "/../Public/img/imgDispositivos/";
                    if (!is_dir($dir)) mkdir($dir, 0777, true);
                    $fileName = basename($_FILES['img_dispositivo']['name']);
                    $img_dispositivo = $fileName;
                    move_uploaded_file($_FILES['img_dispositivo']['tmp_name'], $dir . $fileName);
                }
                $this->deviceModel->updateDevice($id, $categoria_id, $marca, $modelo, $descripcion_falla, $img_dispositivo);

                $admin = Auth::user();
                $this->historialController->agregarAccion(
                    "Actualización de dispositivo",
                    "{$admin['name']} actualizó el dispositivo con ID {$id}."
                );
                header('Location: /ProyectoPandora/Public/index.php?route=Device/ListarDevice');
                exit;
            }
            $error = "Todos los campos son obligatorios.";
        }
        $categorias = $this->categoryModel->getAllCategories();
        include __DIR__ . '/../Views/Device/ActualizarDevice.php';
    }

    public function deleteDevice()
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
        if ($this->deviceModel->deleteDevice($deviceId)) {
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
        $user = Auth::user();
        if (!$user) {
            header('Location: /ProyectoPandora/Public/index.php?route=Auth/Login');
            exit;
        }

        $categoryId = $_GET['id'] ?? 0;
        if (!$categoryId) {
            header('Location: /ProyectoPandora/Public/index.php?route=Device/ListarCategoria&error=CategoryNotFound');
            exit;
        }
        if ($this->categoryModel->deleteCategory($categoryId)) {
            //Guardar en Historial
            $accion = "Se Elimino una Categoria";
            $detalle = "Usuario {$user['name']} elimino la categoria con ID: $categoryId";
            $this->historialController->agregarAccion($accion, $detalle);

            header('Location: /ProyectoPandora/Public/index.php?route=Device/ListarCategoria&success=1');
            exit;
        }
        header('Location: /ProyectoPandora/Public/index.php?route=Device/ListarCategoria&error=ErrorDeletingCategory');
        exit;
    }
}
