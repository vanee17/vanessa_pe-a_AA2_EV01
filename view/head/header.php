<?php
require_once("c://laragon/www/vanessa_peña_AA2_EV01/view/head/head.php");
?>
<?php if (empty($_SESSION['user'])): ?>
    <div class="content_login">
        <div class="div_title text-center">
            <img src="/vanessa_peña_AA2_EV01/asset/img/white-shark.png" alt="logo">
            <h1 class="title">Inventa System</h1>
        </div>
        <div class="div_button text-center">
            <a href="/vanessa_peña_AA2_EV01/view/home/login.php" type="button" class="button">Inicia Sesion</a>
            <a href="/vanessa_peña_AA2_EV01/view/home/signup.php" type="button" class="button">Registrate</a>
        </div>
    </div>
<?php else: ?>
    <header>
        <div class="logo">
            <img src="/vanessa_peña_AA2_EV01/asset/img/small_shark.png" alt="logo">
            <h1><a href="/vanessa_peña_AA2_EV01/view/home/panelControl.php"><span style="color:#1e2631;">INVENTA SYSTEM</span></a></h1>
        </div>
    </header>

    <div class="container-fluid">
        <div class="row">
            <!-- Navbar -->
            <nav class="col-2 col-md-2 col-lg-2border-start vh-100 d-flex flex-column p-3 navbar">
                <ul class="nav flex-column w-100 mt-4">
                    <li class="nav-item list">
                        <a class="item_nav d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#facturacionSub" role="button" aria-expanded="false" aria-controls="facturacionSub">
                            <span><i class="bi bi-cash-coin"></i> Facturación</span>
                        </a>
                        <ul class="collapse list-unstyled ps-4" id="facturacionSub">
                            <li class="list"><a class="item_nav" href="#">Caja</a></li>
                        </ul>
                    </li>
                    <li class="nav-item list">
                        <a class="item_nav d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#movimientosSub" role="button" aria-expanded="false" aria-controls="movimientosSub">
                            <span><i class="bi bi-activity"></i> Movimientos</span>
                        </a>
                        <ul class="collapse list-unstyled ps-4" id="movimientosSub">
                            <li class="list"><a class="item_nav" href="#">Ventas</a></li>
                        </ul>
                    </li>
                    <li class="nav-item list">
                        <a class="item_nav d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#inventarioSub" role="button" aria-expanded="false" aria-controls="inventarioSub">
                            <span><i class="bi bi-clipboard-check"></i> Inventario</span>
                        </a>
                        <ul class="collapse list-unstyled ps-4" id="inventarioSub">
                            <li class="list"><a class="item_nav" href="#">Productos</a></li>
                            <li class="list"><a class="item_nav" href="/inventa_system/view/home/suppliers.php">Proveedores</a></li>
                            <li class="list"><a class="item_nav" href="#">Clientes</a></li>
                        </ul>
                    </li>
                    <li class="nav-item list">
                        <a class="item_nav" href="#"><i class="bi bi-pie-chart-fill"></i> Reportes</a>
                    </li>
                    <li class="nav-item list">
                        <a class="item_nav d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#adminSub" role="button" aria-expanded="false" aria-controls="adminSub">
                            <span><i class="bi bi-person-fill-gear"></i> Administración</span>
                        </a>
                        <ul class="collapse list-unstyled ps-4" id="adminSub">
                            <li class="list"><a class="item_nav" href="#">Permisos</a></li>
                            <li class="list"><a class="item_nav" href="#">Usuarios</a></li>
                            <li class="list"><a class="item_nav" href="#">Notificaciones</a></li>
                        </ul>
                    </li>
                </ul>
                <hr>
                <div class="dropup pb-4 logout">
                    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://github.com/mdo.png" alt="hugenerd" width="30" height="30" class="rounded-circle">
                        <span class="d-none d-sm-inline mx-1 l_navbar">
                            <?= $_SESSION["user"] ?>
                        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                        <!-- <li><a class="dropdown-item" href="#">Editar</a></li>
                        <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li> -->
                        <li>
                            <a class="dropdown-item" href="/vanessa_peña_AA2_EV01/view/home/logout.php">logout</a>
                        </li>
                    </ul>
                </div>
            </nav>
        <?php endif ?>

        <!-- <div class="bd_content w-100"> -->