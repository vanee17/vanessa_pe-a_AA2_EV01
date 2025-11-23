<?php
require_once __DIR__ . '/../head/header.php';
?>
<div class="col-10 col-md-10 col-lg-10 p-4">
    <div class="container" style="margin-left: 190px; margin-top: 40px">
        <h1 class="text-center">Mis Productos</h1>
        <div class="row">
            <div class="col-2 offset-10">
                <div class="text-center">
                    <button type="button" class="btn w-100 bcolor2" data-bs-toggle="modal"
                        data-bs-target="#modalProd" id="crearProd">
                        <i class="bi bi-plus-circle-fill"></i> Crear
                    </button>
                </div>
            </div>
        </div>
        <br>
        <br>
        <div class="table-responsive">
            <table id="datos_prod" class="table table-bordered table-striped" style="width: 100%;">
                <thead>
                    <tr>
                        <th>Codigo Serial</th>
                        <th>Producto</th>
                        <th>Proveedor</th>
                        <th>Cantidad</th>
                        <th>Unidad</th>
                        <th>Valor</th>
                        <th>Descripcion</th>
                        <th>Editar</th>
                        <th>Borrar</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <!--    modal-->

    <div class="modal fade" id="modalProd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content form">
                <div class="modal-header comb1">
                    <h5 class="modal-title opt_form" id="exampleModalLabel">Crea un nuevo Producto</h5>
                    <button type="button" class="btn-close bcolor2" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form method="POST" id="formularioProd">
                    <div>
                        <div class="modal-body color1">
                            <label class="opt_form">Codigo Serial</label>
                            <input type="text" name="serial" id="serial" class="form-control form-prod">
                            <br>
                            <label class="opt_form">Nombre de Producto</label>
                            <input type="text" name="nombre" id="nombre" class="form-control form-prov">
                            <br>

                            <label class="opt_form">Descripcion</label>
                            <input type="text" name="descripcion" id="descripcion" class="form-control form-prov">
                            <br>

                            <label class="opt_form">Selecciona un Proveedor</label>
                            <select class="form-control" required id="proveedor" name="proveedor">
                            </select>
                            <br>

                            <label class="opt_form">Cantidad</label>
                            <input type="text" name="cantidad" id="cantidad" class="form-control form-prov">
                            <br>
                            <label class="opt_form">Unidad</label>
                            <input type="text" name="unidad" id="unidad" class="form-control form-prov">
                            <br>

                            <label class="opt_form">Valor Ingreso</label>
                            <input type="text" name="valorIngreso" id="valorIngreso" class="form-control form-prov">
                            <br>

                            <label class="opt_form">Valor Venta</label>
                            <input type="text" name="valorVenta" id="valorVenta" class="form-control form-prov">
                            <br>
                        </div>
                        <div class="modal-footer color1">
                            <input type="hidden" name="id_prod" id="id_prod">
                            <input type="hidden" name="operation" id="operation">
                            <input type="submit" name="action" id="action" class="btn w-100 bcolor2">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
require_once("c://laragon/www/vanessa_peña_AA2_EV01/view/head/footer.php");
?>