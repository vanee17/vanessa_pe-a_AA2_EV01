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

        public function filterUsers()
    {
        $query = "SELECT * FROM usuario ";

        if (isset($_POST["search"]["value"])) {
            $query .= 'WHERE nombre LIKE "%' . $_POST["search"]["value"] . '%" ';
            $query .= 'OR correo LIKE "%' . $_POST["search"]["value"] . '%" ';
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

    public function viewEditUsers()
    {
        if (isset($_POST["id_user"])) {
            $statement = $this->PDO->prepare("SELECT * FROM inventa_system.usuario WHERE id = :id LIMIT 1");
            $statement->bindParam(':id', $_POST['id_user'], PDO::PARAM_INT);
            try {
                $statement->execute();
                return $statement->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return false;
            }
        }
        return [];
    }

    public function deleteUser($idUser)
    {
        if (isset($_POST["id_user"])) {
            $statement = $this->PDO->prepare("DELETE FROM inventa_system.usuario WHERE id = ?");
            $statement->bindParam(1, $_POST["id_user"]);
            $result = $statement->execute();

            if ($result) {
                echo 1;
            } else {
                echo 0;
            }
        }
    }

        public function updateUser($Name, $number_document, $email, $rol, $user, $password, $idUser)
    {
        if ($_POST["operation"] == "create") {
                // validar que el usuario no exista
                try {
                    // validar usuario
                    $chk = $this->PDO->prepare("SELECT COUNT(*) as cnt FROM inventa_system.usuario WHERE usuario = ?");
                    $chk->execute([$user]);
                    $count = $chk->fetchColumn();
                    if ($count > 0) {
                        echo json_encode(["result" => 0, "action" => 'create', "message" => 'El usuario ya está asignado']);
                        return;
                    }
                    // validar correo
                    $chk2 = $this->PDO->prepare("SELECT COUNT(*) as cnt FROM inventa_system.usuario WHERE correo = ?");
                    $chk2->execute([$email]);
                    $count2 = $chk2->fetchColumn();
                    if ($count2 > 0) {
                        echo json_encode(["result" => 0, "action" => 'create', "message" => 'El correo ya está registrado']);
                        return;
                    }

                    $statement = $this->PDO->prepare("INSERT INTO inventa_system.usuario (nombre, numero_documento, correo, rol, usuario, clave) VALUES (?, ?, ?, ?, ?, ?)");
                    $statement->bindParam(1, $Name);
                    $statement->bindParam(2, $number_document);
                    $statement->bindParam(3, $email);
                    $statement->bindParam(4, $rol);
                    $statement->bindParam(5, $user);
                    $statement->bindParam(6, $password);

                    $result = $statement->execute();

                    if ($result) {
                        echo json_encode(["result" => 1, "action" => 'create']);
                    } else {
                        echo json_encode(["result" => 0, "action" => 'create', "message" => 'Error al crear usuario']);
                    }
                    return;
                } catch (PDOException $e) {
                    echo json_encode(["result" => 0, "action" => 'create', "message" => $e->getMessage()]);
                    return;
                }
        } elseif ($_POST["operation"] == "update") {
                // validar que no exista otro usuario con el mismo nombre
                try {
                // validar usuario
                $chk = $this->PDO->prepare("SELECT id FROM inventa_system.usuario WHERE usuario = ? LIMIT 1");
                $chk->execute([$user]);
                $row = $chk->fetch(PDO::FETCH_ASSOC);
                if ($row && intval($row['id']) !== intval($idUser)) {
                    echo json_encode(["result" => 0, "action" => 'update', "message" => 'El usuario ya está asignado a otro registro']);
                    return;
                }
                // validar correo
                $chkc = $this->PDO->prepare("SELECT id FROM inventa_system.usuario WHERE correo = ? LIMIT 1");
                $chkc->execute([$email]);
                $rowc = $chkc->fetch(PDO::FETCH_ASSOC);
                if ($rowc && intval($rowc['id']) !== intval($idUser)) {
                    echo json_encode(["result" => 0, "action" => 'update', "message" => 'El correo ya está asignado a otro registro']);
                    return;
                }

                $statement = $this->PDO->prepare("UPDATE inventa_system.usuario SET nombre = ?, numero_documento = ?, correo = ?, rol = ?, usuario = ?, clave = ? WHERE id = ?");
                    $statement->bindParam(1, $Name);
                    $statement->bindParam(2, $number_document);
                    $statement->bindParam(3, $email);
                    $statement->bindParam(4, $rol);
                    $statement->bindParam(5, $user);
                    $statement->bindParam(6, $password);
                    $statement->bindParam(7, $idUser);

                    $result = $statement->execute();
                    if ($result) {
                        echo json_encode(["result" => 1, "action" => 'update']);
                    } else {
                        echo json_encode(["result" => 0, "action" => 'update', "message" => 'Error al actualizar usuario']);
                    }
                    return;
                } catch (PDOException $e) {
                    echo json_encode(["result" => 0, "action" => 'update', "message" => $e->getMessage()]);
                    return;
                }
        } else {
            echo "info no detectada";
        }
    }
}
