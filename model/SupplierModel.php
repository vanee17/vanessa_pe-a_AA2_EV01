<?php

class SupplierModel
{

    private $PDO;

    //Constructor to initialize the database connection
    public function __construct()
    {
        require_once(__DIR__ . '/../config/db.php');
        $pdo = new db();
        $this->PDO = $pdo->connection();
    }

    //Method to get all suppliers
    public function get_suppliers()
    {
        $statement = $this->PDO->prepare("SELECT * FROM inventa_system.proveedor");
        try {
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    //Method to filter suppliers for DataTables
    public function filterSuppliers()
    {
        $query = "SELECT * FROM proveedor ";

        if (isset($_POST["search"]["value"])) {
            $query .= 'WHERE nombre_empresa LIKE "%' . $_POST["search"]["value"] . '%" ';
            $query .= 'OR contacto_directo LIKE "%' . $_POST["search"]["value"] . '%" ';
        }
       
        if (isset($_POST["order"])) {
            $query .= 'ORDER BY ' . $_POST['order'][0]['column'] + 1 . ' ' . $_POST['order'][0]['dir'] . ' ';
        } else {
            $query .= 'ORDER BY id DESC ';
        }
        if (isset($_POST["length"]) && $_POST["length"] != -1) {
            $query .= 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
        }
        
        try {
            $stmt = $this->PDO->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll();
            return $result;
            
        } catch (PDOException $e) {
            echo "Error en la consulta: " . $e->getMessage();
            return array();
        }
    }

    //Method to view a specific supplier for editing
    public function viewEditSupplier()
    {
        if (isset($_POST["id_prov"])) {
            $statement = $this->PDO->prepare("SELECT * FROM proveedor WHERE id = '" . $_POST["id_prov"] . "' LIMIT 1");
            $statement->execute();
            return $result = $statement->fetchAll();
        }
    }

    //Method to create or update a supplier
    public function updateSupplier($companyName, $nit, $companyAdress, $companyPhone, $directContact, $contactPhone, $idSupplier)
    {
        if ($_POST["operation"] == "create") {
            $statement = $this->PDO->prepare("INSERT INTO inventa_system.proveedor (nombre_empresa, nit, direccion, telefono, contacto_directo, telefono_contacto) VALUES (?, ?, ?, ?, ?, ?)");

            $statement->bindParam(1, $companyName);
            $statement->bindParam(2, $nit);
            $statement->bindParam(3, $companyAdress);
            $statement->bindParam(4, $companyPhone);
            $statement->bindParam(5, $directContact);
            $statement->bindParam(6, $contactPhone);

            $result = $statement->execute();

            if ($result) {
                $response = [
                    "result" => 1,
                    "action" => 'create'
                ];
                echo json_encode($response);
            } else {
                $response = [
                    "result" => 0,
                    "action" => 'create'
                ];
                echo json_encode($response);
            }
        } elseif ($_POST["operation"] == "update") {
            $statement = $this->PDO->prepare("UPDATE inventa_system.proveedor SET nombre_empresa = ?, nit = ?, direccion = ?, telefono = ?, contacto_directo = ?, telefono_contacto = ? WHERE id = ?");

            $statement->bindParam(1, $companyName);
            $statement->bindParam(2, $nit);
            $statement->bindParam(3, $companyAdress);
            $statement->bindParam(4, $companyPhone);
            $statement->bindParam(5, $directContact);
            $statement->bindParam(6, $contactPhone);
            $statement->bindParam(7, $idSupplier);

            $result = $statement->execute();
            if ($result) {
                $response = [
                    "result" => 1,
                    "action" => 'update'
                ];
                echo json_encode($response);
            } else {
                $response = [
                    "result" => 0,
                    "action" => 'update'
                ];
                echo json_encode($response);
            }
        } else {
            echo "info no detectada";
        }
    }

    //Method to delete a supplier
    public function deleteSupplier($idSupplier)
    {
        if (isset($_POST["id_prov"])) {
            $statement = $this->PDO->prepare("DELETE FROM proveedor WHERE id = ?");
            $statement->bindParam(1, $idSupplier);
            $result = $statement->execute();

            if ($result) {
                echo 1;
            } else {
                echo 0;
            }
        }
    }
}
