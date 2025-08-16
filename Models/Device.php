<?php

class DeviceModel
{
    private $connection;

    public function __construct($dbConnection)
    {
        $this->connection = $dbConnection;
    }
    public function createDevice($userId, $categoriaId, $marca, $modelo, $descripcion, $img_dispositivo)
    {
        $stmt = $this->connection->prepare("INSERT INTO dispositivos (user_id, categoria_id, marca, modelo, descripcion_falla, img_dispositivo) VALUES (?, ?, ?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("iissss", $userId, $categoriaId, $marca, $modelo, $descripcion, $img_dispositivo);
            return $stmt->execute();
        }
        return false;
    }
    public function getDevicesByUserId($userId)
    {
        $stmt = $this->connection->prepare("SELECT * FROM dispositivos WHERE user_id = ?");
        if ($stmt) {
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }
    public function getAllDevices()
    {
        $stmt = $this->connection->prepare(" SELECT d.*, u.name as users, c.name as categoria FROM dispositivos d 
        JOIN users u ON d.user_id = u.id 
        JOIN categorias c ON d.categoria_id = c.id
        ");
        if ($stmt) {
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }
    public function updateDevice($deviceId, $categoriaId, $marca, $modelo, $descripcion, $img_dispositivo)
    {
        $stmt = $this->connection->prepare("UPDATE dispositivos SET categoria_id = ?, marca = ?, modelo = ?, descripcion_falla = ?, img_dispositivo = ? WHERE id = ?");
        if ($stmt) {
            $stmt->bind_param("issssi", $categoriaId, $marca, $modelo, $descripcion, $img_dispositivo, $deviceId);
            return $stmt->execute();
        }
        return false;
    }


    public function deleteDevice($deviceId)
    {
        $stmt = $this->connection->prepare("DELETE FROM dispositivos WHERE id = ?");
        if ($stmt) {
            $stmt->bind_param("i", $deviceId);
            return $stmt->execute();
        }
        return false;
    }
}
