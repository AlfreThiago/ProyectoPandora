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
        $db = new Database();
        $db->connectDatabase();

        $this->historialController = new HistorialController();
        $this->deviceModel = new DeviceModel($db->getConnection());
        $this->categoryModel = new CategoryModel($db->getConnection());
    }

    public function ActualizarDevice()
    {
        Auth::checkRole(['Administrador', 'Supervisor', 'Tecnico', 'Cliente']);

        $id = $_GET['id'] ?? null;
        if (!$id || !is_numeric($id)) return exit("ID inválido.");

        $dispositivo = $this->deviceModel->findDeviceById((int)$id);
        if (!$dispositivo) return exit("Dispositivo no encontrado.");

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            extract($_POST); // crea $marca, $modelo, $descripcion_falla, $categoria_id

            if ($marca && $modelo && $descripcion_falla && $categoria_id) {
                // Imagen → mantener la actual si no se sube nada
                $imgDispositivo = $dispositivo['img_dispositivo'];
                if (!empty($_FILES['img_dispositivo']['name'])) {
                    $dir = __DIR__ . "/../Public/img/imgDispositivos/";
                    is_dir($dir) || mkdir($dir, 0777, true);

                    $fileName = basename($_FILES['img_dispositivo']['name']);
                    $imgDispositivo = "img/imgDispositivos/" . $fileName;
                    move_uploaded_file($_FILES['img_dispositivo']['tmp_name'], $dir . $fileName);
                }

                $this->deviceModel->updateDevice($id, $marca, $modelo, $descripcion_falla, $categoria_id, $imgDispositivo);

                $admin = Auth::user();
                $this->historialController->agregarAccion(
                    "Actualización de dispositivo",
                    "{$admin['name']} actualizó el dispositivo con ID {$id}."
                );

                return header('Location: /ProyectoPandora/Public/index.php?route=Admin/ListarDevices');
            }
            $error = "Todos los campos son obligatorios.";
        }

        $categorias = $this->categoryModel->getAllCategories();
        include __DIR__ . '/../Views/Device/ActualizarDevice.php';
    }
}
