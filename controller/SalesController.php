<?php

class SalesController
{
    private $salesModel;

    public function __construct()
    {
        require_once("c://laragon/www/vanessa_peña_AA2_EV01/model/SalesModel.php");

        $this->salesModel = new SalesModel();
    }

    //---------------------funcionalidad para llenar el select de proveedores con los nombres---------------------//
    public function drawSales()
    {
        $resultado = $this->salesModel->getSales();
        $datos = array();
        $filtered_rows = count($resultado);

        foreach ($resultado as $fila) {
            $subArray = array();
            $subArray["numero_venta"] = $fila["numero_venta"];
            $subArray["fecha_venta"] = $fila["fecha_venta"];
            $subArray["id_cliente"] = $fila["id_cliente"];
            $subArray["id_producto"] = $fila["id_producto"];
            $subArray["cantidad"] = $fila["cantidad"];
            $subArray["unidad"] = $fila["unidad"];
            $subArray["precio_actual"] = $fila["precio_actual"];
            $subArray["precio_venta"] = $fila["precio_venta"];
            $subArray["accion1"] = '<button type="button" name="borrar" id="' . $fila["id"] . '" class="btn btn-danger btn-xs borrarVent">Borrar</button>';
            $datos[] = $subArray;
        }

        $salida = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => $filtered_rows,
            "recordsFiltered" => count($this->salesModel->getSales()),
            "data" => $datos
        );

        echo json_encode($salida);
    }

    // public function drawNamesSuppliers()
    // {
    //     $resultado = $this->supplierModel->getSuppliers();
    //     echo json_encode($resultado);
    // }

    // public function drawNamesProducts()
    // {
    //     $resultado = $this->productModel->getProductsDraw();
    //     echo json_encode($resultado);
    // }

    //Funcion para eliminar un proveedor
    public function deleteSales()
    {
        $idSale = $_POST['id_sale'];
        return $this->salesModel->deleteSales($idSale);
    }
}

$SalesController = new SalesController();
if (isset($_GET["f"])) {
    $function_act = $_GET["f"];
    switch ($function_act) {
        case "drawsales":
            $SalesController->drawSales();
            break;

        case "deletesales":
            $SalesController->deleteSales();
            break;

        default:
            break;
    }
} else {
    echo "La variable no está presente en el POST.";
}
