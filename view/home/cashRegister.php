<?php
require_once __DIR__ . '/../head/header.php';
?>
<div class="col-10 col-md-10 col-lg-10 p-4">
    <div class="container" style="margin-left: 190px; margin-top: 40px">
        <h1 class="text-center">Generar Factura</h1>
        <br>
        <br>
        <div class="table-responsive">
            <form method="POST" id="formularioFact">
                <div>
                    <div class="modal-body color1">
                        <label>Nombre de Cliente</label>
                        <select name="id_cliente" id="id_cliente" class="form-control">
                        </select>
                        <br>

                        <label>Documento</label>
                        <input type="text" name="documento" id="documento" class="form-control">
                        <br>

                        <label>Telefono</label>
                        <input type="text" name="telefono" id="telefono" class="form-control">
                        <br>

                        <label>Productos</label>
                        <br>
                        <div id="contenedor_productos">

                            <div style="display:flex; gap:10px; margin-bottom:5px; font-weight:bold;">
                                <div style="width:180px;">Producto</div>
                                <div style="width:100px;">Cantidad</div>
                                <div style="width:120px;">Unidad</div>
                                <div style="width:120px;">Precio Unitario</div>
                                <div style="width:120px;">Total</div>
                                <div style="width:50px;"></div>
                            </div>

                            <div class="fila_producto" style="display:flex; gap:10px; align-items:center; margin-bottom:10px;">

                                <select class="form-control productos" style="width:180px;"></select>

                                <input type="number" class="form-control cantidad" value="1" min="1" style="width:100px;">

                                <select class="form-control unidad" style="width:120px;">
                                    <option value="unidad">Unidad</option>
                                    <option value="kg">Kilogramo</option>
                                    <option value="litro">Litro</option>
                                    <option value="caja">Caja</option>
                                </select>

                                <input type="text" class="form-control precio" readonly style="width:120px;">

                                <input type="text" class="form-control total" readonly style="width:120px;">

                                <button type="button" class="btn btn-danger eliminar_producto">X</button>

                            </div>

                        </div>

                        <br>

                        <button type="button" id="agregar_producto" class="btn btn-success">
                            + Agregar Producto
                        </button>

                        <br>
                        <br>
                        <label>forma de pago</label>
                        <br>
                        <label>
                            <input type="radio" name="metodo_pago" value="efectivo">
                            Efectivo
                        </label>
                        <br>
                        <label>
                            <input type="radio" name="metodo_pago" value="transferencia">
                            Transferencia
                        </label>
                        <br>
                        <label>
                            <input type="radio" name="metodo_pago" value="tarjeta">
                            Tarjeta
                        </label>
                        <br>

                        <label>Vendedor</label>
                        <select name="usuario" id="usuario" class="form-control">
                        </select>
                        <br>
                    </div>
                    <div class="modal-footer color1">
                        <input type="submit" name="action" id="action" class="btn w-100 bcolor2" value="Crear Factura">
                        <input type="hidden" name="operation" id="operation">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
require_once("c://laragon/www/vanessa_peña_AA2_EV01/view/head/footer.php");
?>