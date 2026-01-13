<?php

class DataBase
{
    private $host = "localhost";
    private $dbname = "mabagnole";
    private $user = "root";
    private $pass = "";
    public $conn;


     public function getConnection() {
        $this->conn = null;

        try {
            $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset=utf8";
            $this->conn = new PDO($dsn, $this->user, $this->pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage() . "<br>". $exception->getLine();
        }

        return $this->conn;
    }
}