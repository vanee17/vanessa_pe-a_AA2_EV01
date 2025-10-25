<?php
    require_once("c://laragon/www/inventa_system/controller/HomeController.php");
    $obj = new HomeController();
    $name = $obj->clearString($_POST['name']);
    $document = $_POST["document"];
    $email = $_POST["email"];
    $nameUser = $_POST["nameUser"];
    $passwords = $_POST["passwords"];
    $confirmPassword = $_POST["confirmPassword"];


    if (empty($name) || empty($document) || empty($email) || empty($nameUser) || empty($passwords) || empty($confirmPassword)) {
        $status =  0;
    }else{
        if ($passwords === $confirmPassword) {
            if($obj->saveUser($name, $document, $email, $nameUser, $passwords) == false){
                $status =  2;
            }else{
                $status = 1;
            }
        }else{
            $status =  3;
        }
    }

    echo $status;