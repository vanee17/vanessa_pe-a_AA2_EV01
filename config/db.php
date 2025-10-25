<?php

class db{
    private $host = "localhost";
    private $dbname = "inventa_system";
    private $user = "root";
    private $password = "";

    public function connection(){
        try {
            $PDO = new PDO("mysql:host=".$this->host.";dbname=".$this->dbname,$this->user,$this->password);
            return $PDO;
        } catch (PDOException $e) {
            return $e->getMessage();
        }               
    }
}

// $obj = new db();
// print_r($obj->connection());