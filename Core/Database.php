<?php
class Database
{
    private $connection;
    function connectDatabase()
    {
<<<<<<< HEAD
        // $host = '10.150.17.120';
        // $user = 'root';
        // $password = 'Bruno200@';
        // $database = 'pandoraDB';
=======
        
        
        
        
>>>>>>> 6dee861c8740e7cfd2ccc0c54eb766d02d6e3b10

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
