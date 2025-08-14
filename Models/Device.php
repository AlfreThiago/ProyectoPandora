<?php

class DeviceModel
{
    private $connection;

    public function __construct($dbConnection)
    {
        $this->connection = $dbConnection;
    }
    public function createDevice($userId, $deviceName, $deviceType, $categoriaId)
    {
        $stmt = $this->connection->prepare("INSERT INTO devices (user_id, device_name, device_type, categoria_id) VALUES (?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("issi", $userId, $deviceName, $deviceType, $categoriaId);
            return $stmt->execute();
        }
        return false;
    }
}
