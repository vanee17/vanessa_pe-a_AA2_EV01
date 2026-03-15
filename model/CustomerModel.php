<?php

class CustomerModel
{

    private $PDO;

    //Constructor para inicializar la conexión a la base de datos
    public function __construct()
    {
        require_once(__DIR__ . '/../config/db.php');
        $pdo = new db();
        $this->PDO = $pdo->connection();
    }

    public function getCustomers()
    {
        $statement = $this->PDO->prepare("SELECT * FROM inventa_system.cliente");
        try {
            $statement->execute();
            return $statement->fetchAll();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function filterCustomers()
    {
        $base = "SELECT * FROM inventa_system.cliente";
        $params = [];
        $where = '';

        if (!empty($_POST["search"]["value"])) {
            $search = trim($_POST["search"]["value"]);
            // columnas permitidas para búsqueda
            $where = ' WHERE nombre LIKE :search OR numero_documento LIKE :search OR correo LIKE :search';
            $params[':search'] = "%$search%";
        }

        // columnas permitidas para order (índices que envía DataTables)
        $columns = ['id', 'nombre', 'numero_documento', 'direccion', 'telefono', 'correo'];
        $order = ' ORDER BY id DESC ';

        if (isset($_POST["order"][0]["column"])) {
            $colIndex = intval($_POST['order'][0]['column']);
            $colName = isset($columns[$colIndex]) ? $columns[$colIndex] : 'id';
            $dir = (isset($_POST['order'][0]['dir']) && strtolower($_POST['order'][0]['dir']) === 'asc') ? 'ASC' : 'DESC';
            $order = " ORDER BY $colName $dir ";
        }

        $query = $base . $where . $order;

        try {
            $stmt = $this->PDO->prepare($query);
            foreach ($params as $k => $v) {
                $stmt->bindValue($k, $v, PDO::PARAM_STR);
            }
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            error_log('Error en consulta filterCustomers: ' . $e->getMessage());
            return array();
        }
    }

    public function updateCustomers($nombre, $documento, $direccion, $telefono, $correo, $idCustomer)
    {
        if ($_POST["operation"] == "crear") {
            $statement = $this->PDO->prepare("INSERT INTO inventa_system.cliente (nombre, numero_documento, direccion, telefono, correo VALUES (?, ?, ?, ?, ?)");

            $statement->bindParam(1, $nombre);
            $statement->bindParam(2, $documento);
            $statement->bindParam(3, $direccion);
            $statement->bindParam(4, $telefono);
            $statement->bindParam(5, $correo);
            $result = $statement->execute();

            if ($result) {
                echo 'Registro creado exitosamente';
            } else {
                echo 'Error al crear el registro';
            }
        } elseif ($_POST["operation"] == "editar") {
            $statement = $this->PDO->prepare("UPDATE inventa_system.cliente SET nombre = ?, numero_documento = ?, direccion = ?, telefono = ?, correo = ? WHERE id = ?");

            $statement->bindParam(1, $nombre);
            $statement->bindParam(2, $documento);
            $statement->bindParam(3, $direccion);
            $statement->bindParam(4, $telefono);
            $statement->bindParam(5, $correo);
            $statement->bindParam(6, $idCustomer);

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

    public function viewEditCustomers()
    {
        if (isset($_POST["id_cliente"])) {
            $statement = $this->PDO->prepare("SELECT * FROM inventa_system.cliente WHERE id = :id LIMIT 1");
            $statement->bindParam(':id', $_POST['id_cliente'], PDO::PARAM_INT);
            try {
                $statement->execute();
                return $statement->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return false;
            }
        }
        return [];
    }

    public function deleteCustomer($idCustomer)
    {
        if (isset($_POST["id_cliente"])) {
            $statement = $this->PDO->prepare("DELETE FROM inventa_system.cliente WHERE id = ?");
            $statement->bindParam(1, $_POST["id_cliente"]);
            $result = $statement->execute();

            if ($result) {
                echo 1;
            } else {
                echo 0;
            }
        }
    }
}
