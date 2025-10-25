<?php
require_once("c://laragon/www/vanessa_peña_AA2_EV01/view/head/header.php");
?>
<?php if (!empty($_SESSION['user'])): ?>
    <main class="col-10 col-md-10 col-lg-10 p-4">
        <div class="container">
            <div class="row">
                <div class="col-sm p_grid">
                    <a href="">
                        <div class="card" style="width: 18rem;">
                            <img src="/vanessa_peña_AA2_EV01/asset/img/receipt.png" class="img_pc" alt="...">
                            <div class="d-flex justify-content-center">
                                <p class="card-text">Registrar Venta</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm p_grid">
                    <a href="" class="">
                        <div class="card" style="width: 18rem;">
                            <img src="/vanessa_peña_AA2_EV01/asset/img/costumer.png" class="img_pc" alt="...">
                            <div class="d-flex justify-content-center">
                                <p class="card-text">Datos Clientes</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm p_grid">
                    <a href="" class="">
                        <div class="card" style="width: 18rem;">
                            <img src="/vanessa_peña_AA2_EV01/asset/img/growth.png" class="img_pc" alt="...">
                            <div class="d-flex justify-content-center">
                                <p class="card-text">Revisar Ventas</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-sm p_grid">
                    <a href="">
                        <div class="card" style="width: 18rem;">
                            <img src="/vanessa_peña_AA2_EV01/asset/img/inventory.png" class="img_pc" alt="...">
                            <div class="d-flex justify-content-center">
                                <p class="card-text">Revisar Productos</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm p_grid">
                    <a href="" class="">
                        <div class="card" style="width: 18rem;">
                            <img src="/vanessa_peña_AA2_EV01/asset/img/supplier.png" class="img_pc" alt="...">
                            <div class="d-flex justify-content-center">
                                <p class="card-text">Revisar Proveedores</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm p_grid">
                    <a href="" class="">
                        <div class="card" style="width: 18rem;">
                            <img src="/vanessa_peña_AA2_EV01/asset/img/dashboard.png" class="img_pc" alt="...">
                            <div class="d-flex justify-content-center">
                                <p class="card-text">Reportes</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </main>
<?php endif ?>

<?php
require_once("c://laragon/www/vanessa_peña_AA2_EV01/view/head/footer.php");
?>