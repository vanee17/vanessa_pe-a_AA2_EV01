<?php

class homeController
{

    private $MODEL;

    public function __construct()
    {
        require_once("c://laragon/www/vanessa_peña_AA2_EV01/model/HomeModel.php");
        $this->MODEL = new homeModel();
    }

    //funcion utilizada para limpiar cadenas de texto
    public function clearString($campo)
    {
        $campo = strip_tags($campo);
        $campo = filter_var($campo, FILTER_UNSAFE_RAW);
        $campo = htmlspecialchars($campo);
        return $campo;
    }

    //funcion utilizada para limpiar correos electronicos
    public function clearEmail($campo)
    {
        $campo = strip_tags($campo);
        $campo = filter_var($campo, FILTER_SANITIZE_EMAIL);
        $campo = htmlspecialchars($campo);
        return $campo;
    }

    //funcion utilizada para encriptar contraseñas
    public function encryptPassword($passwords)
    {
        return password_hash($passwords, PASSWORD_DEFAULT);
    }

    //funcion utilizada para guardar el nuevo registro
    public function saveUser($name, $document, $email, $nameUser, $passwords)
    {
        $valor = $this->MODEL->addNewUser($this->clearString($name), $document,  $this->clearEmail($email), $this->clearEmail($nameUser), $this->encryptPassword($this->clearString($passwords)));
        return $valor;
    }

    //funcion utilizada para verificar las credenciales del usuario
    public function verifyUser($email, $passwords)
    {
        $keydb = $this->MODEL->getPassword($email);
        return (password_verify($passwords, $keydb)) ? true : false;
    }

    //funcion utilizada para obtener la informacion del usuario
    public function getUserInfo($email)
    {
        $userdata = $this->MODEL->getUser($email);
        return $userdata;
    }
}
