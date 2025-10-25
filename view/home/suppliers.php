<?php
require_once __DIR__ . '/../head/header.php';
?>
<div class="col-10 col-md-10 col-lg-10 p-4">
    <div class="container" style="margin-left: 190px;">
        <h1 class="text-center">Mis Proveedores</h1>
        <div class="row">
            <div class="col-2 offset-10">
                <div class="text-center">
                    <button type="button" class="btn w-100 bcolor2" data-bs-toggle="modal"
                        data-bs-target="#modalProv" id="crearProv">
                        <i class="bi bi-plus-circle-fill"></i> Crear
                    </button>
                </div>
            </div>
        </div>
        <br>
        <br>
        <div class="table-responsive">
            <table id="datos_prov" class="table table-bordered table-striped" style="width: 100%;">
                <thead>
                    <tr>
                        <th>Empresa</th>
                        <th>Nit</th>
                        <th>Direccion</th>
                        <th>Telefono</th>
                        <th>Contacto Directo</th>
                        <th>Telefono Contacto</th>
                        <th>Editar</th>
                        <th>Borrar</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <!--    modal-->

    <div class="modal fade" id="modalProv" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content form">
                <div class="modal-header comb1">
                    <h5 class="modal-title opt_form" id="exampleModalLabel">Crea un nuevo proveedor</h5>
                    <button type="button" class="btn-close bcolor2" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form method="POST" id="formularioProv">
                    <div>
                        <div class="modal-body color1">
                            <label class="opt_form">Nombre de Empresa</label>
                            <input type="text" name="empresa" id="empresa" class="form-control form-prov">
                            <br>

                            <label class="opt_form">Nit de Empresa</label>
                            <input type="text" name="nit" id="nit" class="form-control form-prov">
                            <br>

                            <label class="opt_form">Direccion de Empresa</label>
                            <input type="text" name="direccion" id="direccion" class="form-control form-prov">
                            <br>

                            <label class="opt_form">Telefono de Empresa</label>
                            <input type="number" name="telEmpresa" id="telEmpresa" class="form-control form-prov">
                            <br>

                            <label class="opt_form">Contacto Directo</label>
                            <input type="text" name="encargado" id="encargado" class="form-control form-prov">
                            <br>

                            <label class="opt_form">Telefono de Contacto</label>
                            <input type="number" name="telEncargado" id="telEncargado" class="form-control form-prov">
                            <br>
                        </div>
                        <div class="modal-footer color1">
                            <input type="hidden" name="id_prov" id="id_prov">
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
require_once("c://laragon/www/inventa_system/view/head/footer.php");
?>