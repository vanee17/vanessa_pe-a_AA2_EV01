<?php
require_once __DIR__ . '/../head/header.php';
?>
<div class="col-10 col-md-10 col-lg-10 p-4">
    <div class="container" style="margin-left: 190px; margin-top: 40px">
        <h1 class="text-center">Mis Clientes</h1>
        <div class="row">
            <div class="col-2 offset-10">
                <div class="text-center">
                    <button type="button" class="btn w-100 bcolor2" data-bs-toggle="modal"
                        data-bs-target="#modalClient" id="crearClient">
                        <i class="bi bi-plus-circle-fill"></i> Crear
                    </button>
                </div>
            </div>
        </div>
        <br>
        <br>
        <div class="table-responsive">
            <table id="datos_client" class="table table-bordered table-striped" style="width: 100%;">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Documento</th>
                        <th>Direccion</th>
                        <th>Telefono</th>
                        <th>Correo Electronico</th>
                        <th>Editar</th>
                        <th>Borrar</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <!--    modal-->

    <div class="modal fade" id="modalClient" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content form">
                <div class="modal-header comb1">
                    <h5 class="modal-title opt_form" id="exampleModalLabel">Crea un nuevo Cliente</h5>
                    <button type="button" class="btn-close bcolor2" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form method="POST" id="formularioClient">
                    <div>
                        <div class="modal-body color1">
                            <label class="opt_form">Nombre de Cliente</label>
                            <input type="text" name="nombre" id="nombre" class="form-control form-prov">
                            <br>

                            <label class="opt_form">Documento</label>
                            <input type="text" name="documento" id="documento" class="form-control form-prov">
                            <br>

                            <label class="opt_form">Direccion</label>
                            <input type="text" name="direccion" id="direccion" class="form-control form-prov">
                            <br>

                            <label class="opt_form">Telefono</label>
                            <input type="text" name="telefono" id="telefono" class="form-control form-prov">
                            <br>

                            <label class="opt_form">Correo Electronico</label>
                            <input type="email" name="correo" id="correo" class="form-control form-prov">
                            <br>
                        </div>
                        <div class="modal-footer color1">
                            <input type="hidden" name="id_cliente" id="id_cliente">
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