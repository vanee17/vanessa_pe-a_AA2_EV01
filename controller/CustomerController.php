<?php

class CustomerController
{
    private $customerModel;

    public function __construct()
    {
        require_once("c://laragon/www/vanessa_peña_AA2_EV01/model/CustomerModel.php");

        $this->customerModel = new CustomerModel();
    }

    //---------------------funcionalidad para llenar el select de proveedores con los nombres---------------------//
    public function drawCustomers()
    {
        $resultado = $this->customerModel->filterCustomers();
        $datos = array();
        $filtered_rows = count($resultado);

        foreach ($resultado as $fila) {
            $subArray = array();
            $subArray["nombre"] = $fila["nombre"];
            $subArray["documento"] = $fila["numero_documento"];
            $subArray["telefono"] = $fila["telefono"];
            $subArray["direccion"] = $fila["direccion"];
            $subArray["correo_electronico"] = $fila["correo"];
            $subArray["accion1"] = '<button type="button" name="editar" id="' . $fila["id"] . '" class="btn btn-xs editarClient bcolor2">Editar</button>';
            $subArray["accion2"] = '<button type="button" name="borrar" id="' . $fila["id"] . '" class="btn btn-danger btn-xs borrarClient">Borrar</button>';
            $datos[] = $subArray;
        }

        $salida = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => $filtered_rows,
            "recordsFiltered" => count($this->customerModel->getCustomers()),
            "data" => $datos
        );

        echo json_encode($salida);
    }

    public function drawNamesCustomers()
    {
        $resultado = $this->customerModel->getCustomers();
        echo json_encode($resultado);
    }

    public function updateCustomers()
    {
        $nombre = $_POST['nombre'];
        $documento = $_POST['documento'];
        $direccion = $_POST['direccion'];
        $telefono = $_POST['telefono'];
        $correo = $_POST['correo'];
        $idCustomer = $_POST['id_cliente'];
        return $this->customerModel->updateCustomers($nombre, $documento, $direccion, $telefono, $correo, $idCustomer);
    }

    public function viewEditCustomer()
    {
        $resultado = $this->customerModel->viewEditCustomers();
        $salida = array();
        $cliente = array();
        foreach ($resultado as $fila) {

            $cliente["nombre"]         = $fila["nombre"];
            $cliente["documento"]      = $fila["numero_documento"];
            $cliente["direccion"]      = $fila["direccion"];
            $cliente["telefono"]       = $fila["telefono"];
            $cliente["correo"]         = $fila["correo"];
            $cliente["id_cliente"]     = $fila["id"];

            $salida[] = $cliente;
        }
        echo json_encode($salida);
    }

    //Funcion para eliminar un proveedor
    public function deleteCustomer()
    {
        $idCustomer = $_POST['id_cliente'];
        return $this->customerModel->deleteCustomer($idCustomer);
    }
}

$CustomerController = new CustomerController();
if (isset($_GET["f"])) {
    $function_act = $_GET["f"];
    switch ($function_act) {
        case "drawcustomers":
            $CustomerController->drawCustomers();
            break;

        case "drawnamescustomers":
            $CustomerController->drawNamesCustomers();
            break;

        case "updatecustomer":
            $CustomerController->updateCustomers();
            break;

        case "vieweditcustomer":
            $CustomerController->viewEditCustomer();
            break;

        case "deletecustomer":
            $CustomerController->deleteCustomer();
            break;

        default:
            break;
    }
} else {
    echo "La variable no está presente en el POST.";
}
