<?php
require_once("c://laragon/www/vanessa_peña_AA2_EV01/view/head/head.php");
if (!empty($_SESSION["user"])) {
    header("Location:suppliers.php");
}
?>
<div class="content_login">
    <div class="div_title text-center">
        <img src="/vanessa_peña_AA2_EV01/asset/img/small-white-shark.png" alt="logo">
        <h1 class="title">Ingresa a Inventa System</h1>
    </div>
    <form id="loginForm" class="col-4 login" autocomplete="off">
        <div class="mb-3">
            <label for="exampleInputEmail1" class="opt_form">Correo Electronico</label>
            <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
        </div>
        <div class="mb-3">
            <label for="password" class="opt_form">Clave</label>
            <div class="box_eye">
                <button type="button" class="show_pass" onclick="showPassword('password','eye-password')">
                    <i id="eye-password" class="fas fa-eye change_password"></i>
                </button>
            </div>
            <input type="password" name="password" class="form-control" id="password">
        </div>
        <div class="d-grid gap-2">
            <button type="submit" class="btn button">Submit</button>
        </div>
    </form>
    <div class="col-4 login mt-4">
        No tienes una cuenta? <a href="signup.php" class="links">Registrate ahora</a>
    </div>
</div>

<?php
    require_once("c://laragon/www/vanessa_peña_AA2_EV01/view/head/footer.php");
?>