<?php

class UserController
{
    private $userModel;

    public function __construct()
    {
        require_once("c://laragon/www/vanessa_peña_AA2_EV01/model/UserModel.php");

        $this->userModel = new UserModel();
    }

    public function drawUsers()
    {
        $resultado = $this->userModel->getUsers();
        echo json_encode($resultado);
    }

    public function drawAllUsers()
    {
        $resultado = $this->userModel->FilterUsers();
        $datos = array();
        $filtered_rows = count($resultado);

        foreach ($resultado as $fila) {
            $subArray = array();
            $subArray["nombre"] = $fila["nombre"];
            $subArray["numero_documento"] = $fila["numero_documento"];
            $subArray["correo"] = $fila["correo"];
            $subArray["rol"] = $fila["rol"];
            $subArray["usuario"] = $fila["usuario"];
            $subArray["accion1"] = '<button type="button" name="editar" id="' . $fila["id"] . '" class="btn btn-xs editar bcolor2">Editar</button>';
            $subArray["accion2"] = '<button type="button" name="borrar" id="' . $fila["id"] . '" class="btn btn-danger btn-xs borrar">Borrar</button>';
            $datos[] = $subArray;
        }
        $salida = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => $filtered_rows,
            "recordsFiltered" => count($this->userModel->getUsers()),
            "data" => $datos
        );

        echo json_encode($salida);
    }

        //Funcion para recibir los datos del formulario y enviarlos al modelo
    public function updateUsers()
    {
        $Name               = isset($_POST['nombre']) ? $_POST['nombre'] : '';
        $number_document    = isset($_POST['numero_documento']) ? $_POST['numero_documento'] : '';
        $email              = isset($_POST['correo']) ? $_POST['correo'] : '';
        $rol                = isset($_POST['rol']) ? $_POST['rol'] : '';
        $user               = isset($_POST['usuario']) ? $_POST['usuario'] : '';
        $password           = isset($_POST['clave']) ? $_POST['clave'] : '';
        $idUser             = isset($_POST['id_user']) ? $_POST['id_user'] : '';

        // Validar duplicidad de correo al crear
        require_once(__DIR__ . '/../model/HomeModel.php');
        $homeModel = new HomeModel();
        if (isset($_POST['operation']) && $_POST['operation'] == 'create') {
            if ($homeModel->searchEmail($email) > 0) {
                $response = [
                    'result' => 0,
                    'action' => 'create',
                    'message' => 'El correo ya está registrado'
                ];
                echo json_encode($response);
                return;
            }
        }

        // Encriptar contraseña usando HomeController
        require_once(__DIR__ . '/HomeController.php');
        $homeCtrl = new HomeController();

        $hashedPassword = '';
        $operation = isset($_POST['operation']) ? $_POST['operation'] : '';
        if ($operation == 'create') {
            $hashedPassword = $homeCtrl->encryptPassword($password);
        } elseif ($operation == 'update') {
            if (empty($password)) {
                // conservar la clave actual
                $_POST['id_user'] = $idUser;
                $existing = $this->userModel->viewEditUsers();
                if (!empty($existing) && isset($existing[0]['clave'])) {
                    $hashedPassword = $existing[0]['clave'];
                } else {
                    $hashedPassword = $homeCtrl->encryptPassword($password);
                }
            } else {
                $hashedPassword = $homeCtrl->encryptPassword($password);
            }
        } else {
            $hashedPassword = $homeCtrl->encryptPassword($password);
        }

        return $this->userModel->updateUser($Name, $number_document, $email, $rol, $user, $hashedPassword, $idUser);
    }

    public function viewEditUser()
    {
        $resultado = $this->userModel->viewEditUsers();
        $salida = array();
        $usuario = array();
        foreach ($resultado as $fila) {

            $usuario["nombre"] = $fila["nombre"];
            $usuario["numero_documento"] = $fila["numero_documento"];
            $usuario["correo"] = $fila["correo"];
            $usuario["rol"] = $fila["rol"];
            $usuario["usuario"] = $fila["usuario"];
            $usuario["clave"] = $fila["clave"];
            $usuario["id_user"] = $fila["id"];

            $salida[] = $usuario;
        }
        echo json_encode($salida);
    }

    //Funcion para eliminar un usuario
    public function deleteUser()
    {
        $idUser = $_POST['id_user'];
        return $this->userModel->deleteUser($idUser);
    }
}

$UserController = new UserController();
if (isset($_GET["f"])) {
    $function_act = $_GET["f"];
    switch ($function_act) {
        case "drawusers":
            $UserController->drawUsers();
            break;

        case "drawallusers":
            $UserController->drawAllUsers();
            break;

        case "updateusers":
            $UserController->updateUsers();
            break;

        case "viewedituser":
            $UserController->viewEditUser();
            break;

        case "deleteuser":
            $UserController->deleteUser();
            break;

        default:
            break;
    }
} else {
    echo "La variable no está presente en el POST.";
}
