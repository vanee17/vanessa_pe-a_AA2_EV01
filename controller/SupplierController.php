<?php

class SupplierController
{

    private $MODEL;

    public function __construct()
    {
        require_once("c://laragon/www/inventa_system/model/SupplierModel.php");
        $this->MODEL = new SupplierModel();
    }

    //Funcion para dibujar la tabla de proveedores
    public function drawSupplier()
    {
        $result = $this->MODEL->filterSuppliers();
        $datos = array();
        $filtered_rows = count($result);

        foreach ($result as $fila) {
            $subArray = array();
            $subArray["nombre_empresa"] = $fila["nombre_empresa"];
            $subArray["nit"] = $fila["nit"];
            $subArray["direccion"] = $fila["direccion"];
            $subArray["telefono"] = $fila["telefono"];
            $subArray["contacto_directo"] = $fila["contacto_directo"];
            $subArray["telefono_contacto"] = $fila["telefono_contacto"];
            $subArray["accion1"] = '<button type="button" name="editar" id="' . $fila["id"] . '" class="btn btn-xs editar bcolor2">Editar</button>';
            $subArray["accion2"] = '<button type="button" name="borrar" id="' . $fila["id"] . '" class="btn btn-danger btn-xs borrar">Borrar</button>';
            $datos[] = $subArray;
        }
        // var_dump($subArray);
        // die();
        $salida = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => $filtered_rows,
            "recordsFiltered" => count($this->MODEL->get_suppliers()),
            "data" => $datos
        );

        echo json_encode($salida);
    }

    //Funcion para recibir los datos del formulario y enviarlos al modelo
    public function updateSupplier()
    {
        $companyName    = $_POST['empresa'];
        $nit            = $_POST['nit'];
        $companyAddres  = $_POST['direccion'];
        $companyPhone   = $_POST['telEmpresa'];
        $directContact  = $_POST['encargado'];
        $contactPhone   = $_POST['telEncargado'];
        $idSupplier     = $_POST['id_prov'];

        return $this->MODEL->updateSupplier($companyName, $nit, $companyAddres, $companyPhone, $directContact, $contactPhone, $idSupplier);
    }

    //Funcion para ver los datos de un proveedor especifico para editar
    public function viewEditSupplier()
    {
        $result = $this->MODEL->viewEditSupplier();
        $output = array();
        $proveedor = array();
        foreach ($result as $row) {

            $proveedor["empresa"]       = $row["nombre_empresa"];
            $proveedor["nit"]           = $row["nit"];
            $proveedor["direccion"]     = $row["direccion"];
            $proveedor["telEmpresa"]    = $row["telefono"];
            $proveedor["encargado"]     = $row["contacto_directo"];
            $proveedor["telEncargado"]  = $row["telefono_contacto"];

            $output[] = $proveedor;
        }

        echo json_encode($output);
    }

    //Funcion para eliminar un proveedor
    public function deleteSupplier()
    {
        $idSupplier = $_POST['id_prov'];
        return $this->MODEL->deleteSupplier($idSupplier);
    }
}

$SupplierController = new SupplierController();
if (isset($_GET["f"])) {
    $function_act = $_GET["f"];
    switch ($function_act) {
        case "drawsuppliers":
            $SupplierController->drawSupplier();
            break;
        case "updatesupplier":
            $SupplierController->updateSupplier();
            break;
        case "vieweditsupplier":
            $SupplierController->viewEditSupplier();
            break;
        case "deletesupplier":
            $SupplierController->deleteSupplier();
            break;
        // case "drawnamessuppliers":
        //     $SupplierController->drawNamesSuppliers();
        //     break;
        default:
            break;
    }
} else {
    echo "La variable no está presente en el POST.";
}
