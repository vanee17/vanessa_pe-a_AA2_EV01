<?php

class CashRegisterController
{
    private $cashRegisterModel;

    public function __construct()
    {
        require_once("c://laragon/www/vanessa_peña_AA2_EV01/model/CashRegisterModel.php");

        $this->cashRegisterModel = new CashRegisterModel();
    }

    public function updateCashRegister()
    {
        $id_cliente = $_POST['id_cliente'];
        $metodo_pago = $_POST['metodo_pago'];
        $usuario = $_POST['usuario'];

        // Recibir productos enviados desde JS
        $productos = json_decode($_POST['productos'], true);

        if (!$productos || count($productos) == 0) {
            echo json_encode([
                "status" => false,
                "message" => "No se recibieron productos"
            ]);
            return;
        }

        return $this->cashRegisterModel->updateCashRegister(
            $id_cliente,
            $metodo_pago,
            $usuario,
            $productos
        );
    }
}

$CashRegisterController = new CashRegisterController();
if (isset($_GET["f"])) {
    $function_act = $_GET["f"];
    switch ($function_act) {
        case "updatecashregister":
            $CashRegisterController->updateCashRegister();
            break;

        default:
            break;
    }
} else {
    echo "La variable no está presente en el POST.";
}
