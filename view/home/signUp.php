<?php
require_once("c://laragon/www/vanessa_peña_AA2_EV01/view/head/head.php");
if (!empty($_SESSION["user"])) {
    header("Location:suppliers.php");
}
?>

<div class="content_login">
    <div class="div_title text-center">
        <img src="/vanessa_peña_AA2_EV01/asset/img/small-white-shark.png" alt="logo">
        <h1 class="title">Registrate en Inventa System</h1>
    </div>
    <form id="signupForm" class="col-4 login" autocomplete="off">
        <div class="mb-3">
            <label for="name" class="opt_form">Nombre Completo</label>
            <input type="text" name="name" class="form-control" id="name">
        </div>
        <div class="mb-3">
            <label for="document" class="opt_form">Numero Documento</label>
            <input type="text" name="document" class="form-control" id="document">
        </div>
        <div class="mb-3">
            <label for="email" class="opt_form">Correo Electronico</label>
            <input type="email" name="email" class="form-control" id="email">
        </div>
        <div class="mb-3">
            <label for="nameUser" class="opt_form">Usuario</label>
            <input type="text" name="nameUser" class="form-control" id="nameUser">
        </div>
        <div class="mb-3">
            <label for="password" class="opt_form">Clave</label>
            <div class="box_eye">
                <button type="button" onclick="showPassword('password','eye-password')">
                    <i id="eye-password" class="fas fa-eye change_password"></i>
                </button>
            </div>
            <input type="password" name="passwords" class="form-control" id="password">
        </div>
        <div class="mb-3">
            <label for="confirmPassword" class="opt_form">Repetir Clave</label>
            <div class="box_eye">
                <button type="button" onclick="showPassword('confirmPassword','eye-password2')">
                    <i id="eye-password2" class="fas fa-eye change_password"></i>
                </button>
            </div>
            <input type="password" name="confirmPassword" class="form-control" id="confirmPassword">
        </div>
        <div class="d-grid gap-2">
            <button type="submit" class="btn button">Create</button>
        </div>
    </form>
    <div class="col-4 login mt-4">
        Tienes una cuenta? <a href="login.php" class="links">Inicia Sesion</a>
    </div>

    <?php
    require_once("c://laragon/www/vanessa_peña_AA2_EV01/view/head/footer.php");
    ?>