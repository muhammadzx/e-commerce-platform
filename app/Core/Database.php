<?php

class Database
{
    private PDO $conn;

    public function __construct()
    {
       $config = require __DIR__ . "/../../config/database.php";

        $this->conn = new PDO(
            "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8mb4",
            $config["username"],
            $config["password"]
        );

        $this->conn->setAttribute(
            PDO::ATTR_ERRMODE,
            PDO::ERRMODE_EXCEPTION
        );

        $this->conn->setAttribute(
            PDO::ATTR_DEFAULT_FETCH_MODE,
            PDO::FETCH_ASSOC
        );
    }

    public function connect(): PDO
    {
        return $this->conn;
    }
}