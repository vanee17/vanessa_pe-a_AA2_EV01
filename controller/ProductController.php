<?php

class ProductController
{
    private $productModel;
    private $supplierModel;

    public function __construct()
    {
        require_once("c://laragon/www/vanessa_peña_AA2_EV01/model/ProductModel.php");
        require_once("c://laragon/www/vanessa_peña_AA2_EV01/model/SupplierModel.php");

        $this->productModel = new ProductModel();
        $this->supplierModel = new SupplierModel();
    }

    //---------------------funcionalidad para llenar el select de proveedores con los nombres---------------------//
    public function drawProducts()
    {
        $resultado = $this->productModel->filterProducts();
        $datos = array();
        $filtered_rows = count($resultado);

        foreach ($resultado as $fila) {
            $subArray = array();
            $subArray["serial"] = $fila["codigo_serial"];
            $subArray["nombre"] = $fila["nombre"];
            $subArray["proveedor"] = $fila["nombre_empresa"];
            $subArray["cantidad"] = $fila["cantidad"];
            $subArray["unidad"] = $fila["unidad"];
            $subArray["valor_venta"] = $fila["precio_actual"];
            $subArray["descripcion"] = $fila["descripcion"];
            $subArray["accion1"] = '<button type="button" name="editar" id="' . $fila["id"] . '" class="btn btn-xs editarProd bcolor2">Editar</button>';
            $subArray["accion2"] = '<button type="button" name="borrar" id="' . $fila["id"] . '" class="btn btn-danger btn-xs borrarProd">Borrar</button>';
            $datos[] = $subArray;
        }

        $salida = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => $filtered_rows,
            "recordsFiltered" => count($this->productModel->getProducts()),
            "data" => $datos
        );

        echo json_encode($salida);
    }

    public function drawNamesSuppliers()
    {
        $resultado = $this->supplierModel->getSuppliers();
        echo json_encode($resultado);
    }

    public function drawNamesProducts()
    {
        $resultado = $this->productModel->getProductsDraw();
        echo json_encode($resultado);
    }

    public function updateProduct()
    {
        $serial = $_POST['serial'];
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $proveedor = $_POST['proveedor'];
        $cantidad = $_POST['cantidad'];
        $unidad = $_POST['unidad'];
        $valorIngreso = $_POST['valorIngreso'];
        $valorVenta = $_POST['valorVenta'];
        $idProduct = $_POST['id_prod'];
        return $this->productModel->updateProducts($serial, $proveedor, $nombre, $descripcion, $cantidad, $unidad, $valorIngreso, $valorVenta, $idProduct);
    }

    public function viewEditProduct()
    {
        $resultado = $this->productModel->viewEditProducts();
        $salida = array();
        $producto = array();
        foreach ($resultado as $fila) {

            $producto["serial"]         = $fila["codigo_serial"];
            $producto["nombre"]         = $fila["nombre"];
            $producto["descripcion"]    = $fila["descripcion"];
            $producto["proveedor"]      = $fila["proveedor_id"];
            $producto["cantidad"]       = $fila["cantidad"];
            $producto["unidad"]         = $fila["unidad"];
            $producto["valorIngreso"]   = $fila["precio_entrada"];
            $producto["valorVenta"]     = $fila["precio_actual"];
            $producto["id_prod"]        = $fila["id"];

            $salida[] = $producto;
        }
        echo json_encode($salida);
    }

    //Funcion para eliminar un proveedor
    public function deleteProduct()
    {
        $idProduct = $_POST['id_prod'];
        return $this->productModel->deleteProduct($idProduct);
    }
}

$ProductController = new ProductController();
if (isset($_GET["f"])) {
    $function_act = $_GET["f"];
    switch ($function_act) {
        case "drawproducts":
            $ProductController->drawProducts();
            break;

        case "updateproduct":
            $ProductController->updateProduct();
            break;

        case "vieweditproduct":
            $ProductController->viewEditProduct();
            break;

        case "deleteproduct":
            $ProductController->deleteProduct();
            break;

        case "drawnamessuppliers":
            $ProductController->drawNamesSuppliers();
            break;

        case "drawnamesproducts":
            $ProductController->drawNamesProducts();
            break;

        default:
            break;
    }
} else {
    echo "La variable no está presente en el POST.";
}
