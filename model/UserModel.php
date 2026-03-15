<?php

class UserModel
{

    private $PDO;

    //Constructor para inicializar la conexión a la base de datos
    public function __construct()
    {
        require_once(__DIR__ . '/../config/db.php');
        $pdo = new db();
        $this->PDO = $pdo->connection();
    }

    public function getUsers()
    {
        $statement = $this->PDO->prepare("SELECT * FROM inventa_system.usuario");
        try {
            $statement->execute();
            return $statement->fetchAll();
        } catch (PDOException $e) {
            return false;
        }
    }
}
