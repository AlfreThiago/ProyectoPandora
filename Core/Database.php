<?php
class Database
{
    private $connection;
    function connectDatabase()
    {
        // $host = '192.168.1.13';
        // $user = 'root';
        // $password = 'Bruno200@';
        // $database = 'pandoraDB';

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
