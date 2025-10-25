<?php

class HomeModel
{
    private $PDO;
    public function __construct()
    {
        require_once("c://laragon/www/inventa_system/config/db.php");
        $pdo = new db();
        $this->PDO = $pdo->connection();
    }

    //funcion utilizada para buscar si el correo ya existe
    public function searchEmail($email)
    {
        $statement = $this->PDO->prepare("SELECT correo FROM inventa_system.usuario WHERE correo = ?");
        $statement->bindParam(1, $email);

        $statement->execute();

        $rowCount = $statement->rowCount();

        return $rowCount;
    }

    //funcion utilizada para agregar un nuevo usuario
    public function addNewUser($name, $document, $email, $nameUser, $passwords)
    {
        $statement = $this->PDO->prepare("INSERT INTO inventa_system.usuario (nombre, numero_documento, correo, usuario, clave) VALUES ( ?, ?, ?, ?, ?)");
        $statement->bindParam(1, $name);
        $statement->bindParam(2, $document);
        $statement->bindParam(3, $email);
        $statement->bindParam(4, $nameUser);
        $statement->bindParam(5, $passwords);

        if ($this->searchEmail($email) == 0) {
            $statement->execute();
            return true;
        } else {
            return false;
        }
    }

    //funcion utilizada para obtener la clave de un usuario
    public function getPassword($email)
    {
        $statement = $this->PDO->prepare("SELECT clave FROM inventa_system.usuario WHERE correo = ?");
        $statement->bindParam(1, $email);
        try {
            $statement->execute();
            return $statement->fetch()["clave"];
        } catch (PDOException $e) {
            return false;
        }
    }

    //funcion utilizada para obtener la informacion de un usuario
    public function getUser($email)
    {
        $statement = $this->PDO->prepare("SELECT * FROM inventa_system.usuario WHERE correo = ?");
        $statement->bindParam(1, $email);
        try {
            $statement->execute();
            return $statement->fetch();
        } catch (PDOException $e) {
            return false;
        }
    }
}
