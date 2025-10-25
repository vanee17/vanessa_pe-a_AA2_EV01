<?php

    require_once("c://laragon/www/inventa_system/controller/homeController.php");
    session_start();
    $obj = new homeController();
    $email = $obj->clearEmail($_POST['email']);
    $passwords = $obj ->clearString($_POST['password']);
    $flag = $obj->verifyUser($email, $passwords);
    $userdata= $obj->getUserInfo($email);
   
    if ($flag) {
        $username= '';
        $_SESSION["user"] = $userdata['nombre'];
        $response = 1;
        //header("Location:panelControl.php");
    }else{
        $response = 0;
        //header("Location:login.php?error=".$error);
    }

    echo $response;