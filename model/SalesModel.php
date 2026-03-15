<?php

class SalesModel
{

    private $PDO;

    //Constructor para inicializar la conexión a la base de datos
    public function __construct()
    {
        require_once(__DIR__ . '/../config/db.php');
        $pdo = new db();
        $this->PDO = $pdo->connection();
    }

    public function getSales()
    {
        $statement = $this->PDO->prepare("SELECT * FROM inventa_system.venta");
        try {
            $statement->execute();
            return $statement->fetchAll();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function deleteSales($idSale)
    {
        if (isset($_POST["id_sale"])) {
            $statement = $this->PDO->prepare("DELETE FROM venta WHERE id = ?");
            $statement->bindParam(1, $idSale, PDO::PARAM_INT);
            $result = $statement->execute();

            if ($result) {
                echo 1;
            } else {
                echo 0;
            }
        }
    }
}
