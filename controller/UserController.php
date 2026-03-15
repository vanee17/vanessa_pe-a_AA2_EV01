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
}

$UserController = new UserController();
if (isset($_GET["f"])) {
    $function_act = $_GET["f"];
    switch ($function_act) {
        case "drawusers":
            $UserController->drawUsers();
            break;

        default:
            break;
    }
} else {
    echo "La variable no está presente en el POST.";
}
