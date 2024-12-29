<?php

require_once 'config.php';

class Database
{
    private $username;
    private $password;
    private $host;
    private $port;
    private $database;

    public function __construct()
    {
        $this->username = USERNAME;
        $this->password = PASSWORD;
        $this->host = HOST;
        // $this->port = PORT;
        $this->database = DATABASE;
        
    }

    public function connect()
    {
        try{

            $conn = new PDO(
                "pgsql:host={$this->host};dbname={$this->database}",
                $this->username,
                $this->password
            );

            $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            return $conn;

        }catch(PDOException $e){
            die("Connection failed: ".$e->getMessage());
        }
    }
}