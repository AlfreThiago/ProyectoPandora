<?php
// Database es una clase que maneja la conexión a la base de datos.
// Proporciona un método para conectarse a la base de datos y obtener la conexión actual.
class Database
{
    private $connection;
    function connectDatabase()
    {
        $host = 'localhost';
        $user = 'root';
        $password = '';
        $database = 'pandoradb';

        $this->connection = new mysqli($host, $user, $password, $database);
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }
    public function getConnection()
    {
        return $this->connection;
    }
}
