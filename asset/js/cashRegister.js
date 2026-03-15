//---------------------funcionalidad llenar select clientes---------------------//
$(document).ready(function(){

    var clientes = []; 

    $.ajax({
        url: "../../controller/CustomerController.php?f=drawnamescustomers",
        type: "GET",
        success: function (response) {                
            clientes = JSON.parse(response);

            var select = $("#id_cliente");
            select.empty();
            select.append('<option value="0">--Selecciona una opción--</option>');

            for (var i = 0; i < clientes.length; i++) {
                var option = '<option value="' + clientes[i].id + '">' + clientes[i].nombre + '</option>';
                select.append(option);
            }
        }
    });

    // Cuando cambie el select
    $("#id_cliente").on("change", function(){

        var idSeleccionado = $(this).val();

        if(idSeleccionado == "0"){
            $("#documento").val("");
            $("#telefono").val("");
            return;
        }

        // Buscar cliente en el arreglo
        var cliente = clientes.find(c => c.id == idSeleccionado);

        if(cliente){
            $("#documento").val(cliente.numero_documento);
            $("#telefono").val(cliente.telefono);
        }
    });

    //---------------------funcionalidad llenar select productos---------------------//
    let productos = [];

    // Cargar productos
    $.ajax({
        url: "../../controller/ProductController.php?f=drawnamesproducts",
        type: "GET",
        success: function (response){

            productos = JSON.parse(response);

            llenarSelect($("#contenedor_productos .productos").first());

        }
    });

    // AGREGAR PRODUCTO
    $("#agregar_producto").click(function(){

        let nuevaFila = `
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
        `;

        $("#contenedor_productos").append(nuevaFila);

        // llenar SOLO el select nuevo
        let nuevoSelect = $("#contenedor_productos .fila_producto").last().find(".productos");

        llenarSelect(nuevoSelect);

    });

    function llenarSelect(select){

        select.empty();
        select.append('<option value="0">Seleccionar producto</option>');

        productos.forEach(function(p){
            select.append('<option value="'+p.id+'">'+p.nombre+'</option>');
        });

    }

    // SELECCIONAR PRODUCTO
    $(document).on("change",".productos",function(){

        let fila = $(this).closest(".fila_producto");

        let id = $(this).val();

        let producto = productos.find(p => p.id == id);

        if(producto){

            fila.find(".precio").val(producto.precio_actual);

            let cantidad = fila.find(".cantidad").val();

            let total = producto.precio_actual * cantidad;

            fila.find(".total").val(total);

        }

    });

    // CAMBIAR CANTIDAD
    $(document).on("input",".cantidad",function(){

        let fila = $(this).closest(".fila_producto");

        let id = fila.find(".productos").val();

        let producto = productos.find(p => p.id == id);

        if(producto){

            let cantidad = $(this).val();

            let total = producto.precio_actual * cantidad;

            fila.find(".total").val(total);

        }

    });

    //---------------------funcionalidad llenar select de usuario---------------------//
    $.ajax({
        url: "../../controller/UserController.php?f=drawusers",
        type: "GET",
        success: function (response) {                
            var datos = JSON.parse(response);
            var select = $("#usuario");
            select.empty();
            select.append('<option value="0">--Selecciona una opcion--</option>');
            for (var i = 0; i < datos.length; i++) {
                var option = '<option value="' + datos[i].id + '">' + datos[i].nombre + '</option>';
                select.append(option);
            }
        },
    });

    //funcionalidad crear factura
    $(document).on('submit', '#formularioFact', function(event){

        event.preventDefault();
        $("#operation").val("crear");

        var id_cliente = $('#id_cliente').val();
        var metodo_pago = $('input[name="metodo_pago"]:checked').val();
        var usuario = $('#usuario').val();

        let productos = [];

        $(".fila_producto").each(function(){

            let producto = {
                id_producto: $(this).find(".productos").val(),
                cantidad: $(this).find(".cantidad").val(),
                unidad: $(this).find(".unidad").val(),
                precio: $(this).find(".precio").val(),
                total: $(this).find(".total").val()
            };

            productos.push(producto);

        });

        if(id_cliente != '' && metodo_pago != '' && usuario != '' && productos.length > 0){

            let formData = new FormData(this);

            formData.append("productos", JSON.stringify(productos));

            $.ajax({
                url:"../../controller/CashRegisterController.php?f=updatecashregister",
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(data){

                    console.log(data);

                    $('#formularioFact')[0].reset();

                    Swal.fire({
                        title: "Exito",
                        text: "¡Factura generada con exito!",
                        icon: "success",
                    });

                }
            });

        }else{
            alert('Todos los campos son obligatorios');
        }
    });

});
