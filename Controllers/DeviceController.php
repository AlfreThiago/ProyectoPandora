<?php
require_once __DIR__ . '/../Core/Database.php';
require_once __DIR__ . '/../Models/Device.php';
require_once __DIR__ . '/../Models/Category.php';
require_once __DIR__ . '/../Controllers/HistorialController.php';
require_once __DIR__ . '/../Core/Auth.php';

class DeviceController
{

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

            // Validación básica
            if (!$categoriaId || !$marca || !$modelo || !$img_dispositivo) {
                echo "Todos los campos son obligatorios.";
                return;
            }

            // Guardar imagen
            $rutaDestino = __DIR__ . '/../Public/img/imgDispositivos/' . $img_dispositivo;
            if (!move_uploaded_file($_FILES['img_dispositivo']['tmp_name'], $rutaDestino)) {
                echo "Error al subir la imagen.";
                return;
            }

            // Guardar dispositivo en la base de datos
            $db = new Database();
            $db->connectDatabase();
            $deviceModel = new DeviceModel($db->getConnection());

            if ($deviceModel->createDevice($userId, $categoriaId, $marca, $modelo, $descripcion, $img_dispositivo)) {
                header('Location: /ProyectoPandora/Public/index.php?route=Dash/Home&success=1');
                exit;
            } else {
                echo "Error al registrar el dispositivo.";
            }
        }
    }
    public function AgregarCategoria()
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
                header('Location: /ProyectoPandora/Public/index.php?route=Dash/Category&success=1');
                exit;
            }
            header('Location: /ProyectoPandora/Public/index.php?route=Dash/Device&error=ErrorAlAgregarCategoria');
            exit;
        } else {
            header('Location: /ProyectoPandora/Public/index.php?route=Dash/Category');
        }
    }
    public function EditDevice()
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

            // Validación básica
            if (!$categoriaId || !$marca || !$modelo || !$img_dispositivo) {
                echo "Todos los campos son obligatorios.";
                return;
            }
            // Guardar imagen
            if (!move_uploaded_file($_FILES['img_dispositivo']['tmp_name'], $rutaDestino)) {
                echo "Error al subir la imagen.";
                return;
            }
            // Actualizar dispositivo en la base de datos
            $db = new Database();
            $db->connectDatabase();
            $deviceModel = new DeviceModel($db->getConnection());
            if ($deviceModel->updateDevice($deviceId, $categoriaId, $marca, $modelo, $descripcion, $img_dispositivo)) {
                header('Location: /ProyectoPandora/Public/index.php?route=Dash/TablaDispositivos&success=1');
                exit;
            }
            echo "Error al actualizar el dispositivo.";
        } else {
            $db = new Database();
            $db->connectDatabase();
            $deviceModel = new DeviceModel($db->getConnection());
            $device = $deviceModel->getDevicesByUserId($user['id']);
            if (!$device) {
                echo "Dispositivo no encontrado.";
                return;
            }
            require_once __DIR__ . '/../Views/Dashboard/AdminDash/EditDevice.php';
        }
    }
    public function DeleteDevice()
    {
        $deviceId = $_GET['id'] ?? 0;
        if (!$deviceId) {
            header('Location: /ProyectoPandora/Public/index.php?route=Dash/TablaDispositivos&error=DeviceNotFound');
            exit;
        }
        $db = new Database();
        $db->connectDatabase();
        $deviceModel = new DeviceModel($db->getConnection());
        if ($deviceModel->deleteDevice($deviceId)) {
            header('Location: /ProyectoPandora/Public/index.php?route=Dash/TablaDispositivos&success=1');
            exit;
        }
        header('Location: /ProyectoPandora/Public/index.php?route=Dash/TablaDispositivos&error=ErrorDeletingDevice');
        exit;
    }
}
