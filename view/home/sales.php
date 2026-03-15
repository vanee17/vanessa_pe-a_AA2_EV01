<?php
require_once __DIR__ . '/../head/header.php';
?>
<div class="col-10 col-md-10 col-lg-10 p-4">
    <div class="container" style="margin-left: 190px; margin-top: 40px">
        <h1 class="text-center">Mis Ventas</h1>
        <br>
        <div class="table-responsive">
            <table id="datos_vent" class="table table-bordered table-striped" style="width: 100%;">
                <thead>
                    <tr>
                        <th>Numero de venta</th>
                        <th>Fecha</th>
                        <th>Cliente</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Unidad</th>
                        <th>Precio unitario</th>
                        <th>Total</th>
                        <th>Borrar</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<?php
require_once("c://laragon/www/vanessa_peña_AA2_EV01/view/head/footer.php");
?>