<?php
require_once __DIR__ . '/../Core/Database.php';
require_once __DIR__ . '/../Models/Device.php';
require_once __DIR__ . '/../Models/Category.php';
require_once __DIR__ . '/../Controllers/HistorialController.php';


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
                header('Location: /ProyectoPandora/Public/index.php?route=Device/CrearCategoria&error=CamposRequeridos');
                exit;
            }

            $db = new Database();
            $db->connectDatabase();
            $categoryModel = new CategoryModel($db->getConnection());

            if ($categoryModel->createCategory($nombreCategoria)) {
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
        $id = (int) $_GET['id'];

        // Buscar categoría
        $categorias = $this->categoryModel->findCategoryById($id);
        if (!$categorias) {
            echo "Categoría no encontrada.";
            return;
        }

        // Si envió POST → actualizar
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombreCategoria = $_POST['nombre'] ?? '';
            if (empty($nombreCategoria)) {
                header('Location: /ProyectoPandora/Public/index.php?route=Device/ListarCategoria&error=CamposRequeridos');
                exit;
            }

            $db = new Database();
            $db->connectDatabase();
            $categoryModel = new CategoryModel($db->getConnection());

            if ($categoryModel->updateCategory($id, $nombreCategoria)) {
                header('Location: /ProyectoPandora/Public/index.php?route=Device/ListarCategoria&success=1');
                exit;
            }

            header('Location: /ProyectoPandora/Public/index.php?route=Device/ListarCategoria&error=ErrorAlActualizarCategoria');
            exit;
        }

        // Mostrar vista
        require_once __DIR__ . '/../Views/Device/ActualizarCategoria.php';
    }

    public function ActualizarDevice()
    {
        Auth::checkRole(['Administrador', 'Supervisor', 'Tecnico', 'Cliente']);

        // 1. Validar que exista el ID
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            echo "ID inválido.";
            return;
        }

        $id = $_GET['id'];

        // 2. Buscar el dispositivo
        $dispositivo = $this->deviceModel->findDeviceById($id);
        if (!$dispositivo) {
            echo "Dispositivo no encontrado.";
            return;
        }

        // 3. Procesar formulario si se envía
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (
                !empty($_POST['marca']) &&
                !empty($_POST['modelo']) &&
                !empty($_POST['descripcion_falla']) &&
                !empty($_POST['categoria_id'])
            ) {
                $marca = $_POST['marca'];
                $modelo = $_POST['modelo'];
                $descripcionFalla = $_POST['descripcion_falla'];
                $categoriaId = $_POST['categoria_id'];

                // Imagen
                $uploadDir = __DIR__ . "/../Public/img/imgDispositivos/";

                // crear carpeta si no existe
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                // mantener la actual si no se sube nada
                $imgDispositivo = $dispositivo['img_dispositivo'];

                if (!empty($_FILES['img_dispositivo']['name'])) {
                    $fileName = basename($_FILES['img_dispositivo']['name']);
                    $imgDispositivo = "img/imgDispositivos/" . $fileName;

                    move_uploaded_file(
                        $_FILES['img_dispositivo']['tmp_name'],
                        $uploadDir . $fileName
                    );
                }


                // Actualizar
                $this->deviceModel->updateDevice(
                    $id,
                    $marca,
                    $modelo,
                    $descripcionFalla,
                    $categoriaId,
                    $imgDispositivo
                );

                // Historial
                $admin = Auth::user();
                $accion = "Actualización de dispositivo";
                $detalle = "El administrador {$admin['name']} actualizó el dispositivo con ID {$id}.";
                $this->historialController->agregarAccion($accion, $detalle);

                header('Location: /ProyectoPandora/Public/index.php?route=Admin/ListarDevices');
                exit;
            } else {
                $error = "Todos los campos son obligatorios.";
            }
        }

        // 4. Obtener categorías para el select
        $categorias = $this->categoryModel->getAllCategories();

        // 5. Incluir la vista
        include __DIR__ . '/../Views/Device/ActualizarDevice.php';
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
