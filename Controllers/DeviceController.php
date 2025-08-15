<?php
require_once __DIR__ . '/../Core/Database.php';
require_once __DIR__ . '/../Models/Device.php';

class DeviceController
{

    public function AgregarDispositivo()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $marca = $_POST['marca'] ?? '';
            $modelo = $_POST['modelo'] ?? '';
            $descripcion = $_POST['descripcion_falla'] ?? '';
            $img_dispositivo = $_FILES['img_dispositivo']['name'] ?? '';
            $categoriaId = $_POST['categoria_id'] ?? 0;
            if (empty($deviceName) || empty($deviceType) || empty($deviceLocation) || $categoriaId <= 0) {
                header('Location: /ProyectoPandora/Public/index.php?route=Dash/Device&error=CamposRequeridos');
                exit;
            }
            $db = new Database();
            $db->connectDatabase();
            $deviceModel = new DeviceModel($db->getConnection());

            if ($deviceModel->createDevice($deviceName, $deviceType, $deviceLocation, $categoriaId)) {
                header('Location: /ProyectoPandora/Public/index.php?route=Dash/Device');
                exit;
            } else {
                header('Location: /ProyectoPandora/Public/index.php?route=Dash/Device&error=ErrorAlAgregarDispositivo');
                exit;
            }
        } else {
            require_once __DIR__ . '/../Core/Auth.php';
            Auth::checkRole('Administrador');
            include_once __DIR__ . '/../Views/Includes/Header.php';
            include_once __DIR__ . '/../Views/Dashboard/DeviceDash.php';
        }
    }
}
