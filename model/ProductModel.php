<?php

class ProductModel
{

    private $PDO;

    //Constructor para inicializar la conexión a la base de datos
    public function __construct()
    {
        require_once(__DIR__ . '/../config/db.php');
        $pdo = new db();
        $this->PDO = $pdo->connection();
    }

    public function getProductsDraw()
    {
        $statement = $this->PDO->prepare("SELECT * FROM inventa_system.producto");
        try {
            $statement->execute();
            return $statement->fetchAll();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getProducts()
    {
        $statement = $this->PDO->prepare("SELECT prd.*, prv.nombre_empresa FROM inventa_system.producto as prd LEFT JOIN inventa_system.proveedor as prv ON prv.id = prd.proveedor_id");
        try {
            $statement->execute();
            return $statement->fetchAll();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function filterProducts()
    {
        $query = "SELECT prd.*, prv.nombre_empresa FROM inventa_system.producto as prd LEFT JOIN inventa_system.proveedor as prv ON prv.id = prd.proveedor_id ";
        $salida = array();

        if (isset($_POST["search"]["value"])) {
            $query .= 'WHERE codigo_serial LIKE "%' . $_POST["search"]["value"] . '%" ';
            $query .= 'OR nombre LIKE "%' . $_POST["search"]["value"] . '%" ';
        }

        if (isset($_POST["order"])) {
            $query .= 'ORDER BY ' . $_POST['order'][0]['column'] . ' ' . $_POST['order'][0]['dir'] . ' ';
        } else {
            $query .= 'ORDER BY id DESC ';
        }

        if (isset($_POST["length"]) && $_POST["length"] != -1) {
            $query .= 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
        }

        try {
            $stmt = $this->PDO->prepare($query);
            $stmt->execute();
            $resultado = $stmt->fetchAll();
            return $resultado;
        } catch (PDOException $e) {
            echo "Error en la consulta: " . $e->getMessage();
            return array(); // Devuelve un array vacío en caso de error.
        }
    }

    public function updateProducts($serial, $proveedor, $nombre, $descripcion, $cantidad, $unidad, $valorIngreso, $valorVenta, $idProduct)
    {
        if ($_POST["operation"] == "crear") {
            $statement = $this->PDO->prepare("INSERT INTO inventa_system.producto (nombre, descripcion, precio_actual, cantidad, proveedor_id, codigo_serial, precio_entrada, unidad) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

            $statement->bindParam(1, $nombre);
            $statement->bindParam(2, $descripcion);
            $statement->bindParam(3, $valorVenta);
            $statement->bindParam(4, $cantidad);
            $statement->bindParam(5, $proveedor);
            $statement->bindParam(6, $serial);
            $statement->bindParam(7, $valorIngreso);
            $statement->bindParam(8, $unidad);
            $result = $statement->execute();

            if ($result) {
                echo 'Registro creado exitosamente';
            } else {
                echo 'Error al crear el registro';
            }
        } elseif ($_POST["operation"] == "editar") {
            $statement = $this->PDO->prepare("UPDATE inventa_system.producto SET nombre = ?, descripcion = ?, precio_actual = ?, cantidad = ?, proveedor_id = ?, codigo_serial = ?, precio_entrada = ?,  unidad = ? WHERE id = ?");

            $statement->bindParam(1, $nombre);
            $statement->bindParam(2, $descripcion);
            $statement->bindParam(3, $valorVenta);
            $statement->bindParam(4, $cantidad);
            $statement->bindParam(5, $proveedor);
            $statement->bindParam(6, $serial);
            $statement->bindParam(7, $valorIngreso);
            $statement->bindParam(8, $unidad);
            $statement->bindParam(9, $idProduct);

            $result = $statement->execute();

            if ($result) {
                echo 'Registro editado exitosamente';
            } else {
                echo 'Error al editar el registro';
            }
        } else {
            echo "info no detectada";
        }
    }

    public function viewEditProducts()
    {
        if (isset($_POST["id_prod"])) {
            $statement = $this->PDO->prepare("SELECT prd.*, prv.id FROM inventa_system.producto as prd 
            LEFT JOIN inventa_system.proveedor as prv ON prv.id = prd.proveedor_id 
            WHERE prd.id = :id LIMIT 1
        ");
            $statement->bindParam(':id', $_POST['id_prod'], PDO::PARAM_INT);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }
        return [];
    }

    public function deleteProduct($idProduct)
    {
        if (isset($_POST["id_prod"])) {
            $statement = $this->PDO->prepare("DELETE FROM producto WHERE id = ?");
            $statement->bindParam(1, $idProduct);
            $result = $statement->execute();

            if ($result) {
                echo 1;
            } else {
                echo 0;
            }
        }
    }
}
