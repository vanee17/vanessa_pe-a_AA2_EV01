//---------------------funcionalidad llenar select proveedores---------------------//
$(document).ready(function(){
    $.ajax({
        url: "../../controller/ProductController.php?f=drawnamessuppliers",
        type: "GET",
        success: function (response) {                
            var datos = JSON.parse(response);
            var select = $("#proveedor");
            select.empty();
            select.append('<option value="0">--Selecciona una opcion--</option>');
            for (var i = 0; i < datos.length; i++) {
                var option = '<option value="' + datos[i].id + '">' + datos[i].nombre_empresa + '</option>';
                select.append(option);
            }
        },
    });
});
//peticion ajax con jquery al backend para productos

var dataTableProd = $("#datos_prod").DataTable({
    "processing": true,
    "serverSide": true,
    "order": [],
    "ajax":{
        url: "../../controller/ProductController.php?f=drawproducts",
        type: "POST"
    },
    "columns": [
        { "data": "serial" },
        { "data": "nombre" },
        { "data": "proveedor" },
        { "data": "cantidad" },
        { "data": "unidad" },
        { "data": "valor_venta" },
        { "data": "descripcion" },
        { "data": "accion1" },
        { "data": "accion2" },
    ],
    "columnDefs": [
        {
            "targets":[7,8],
            "orderable": false
        }
    ]
});

 //funcionalidad crear producto     
 $('#crearProd').click(function(){
     $('#formularioProd')[0].reset();
     $('#action').val('Crear Producto');
     $('#operation').val('crear');
 });

$(document).on('submit', '#formularioProd', function(event){
    event.preventDefault();
    var serial = $('#serial').val();
    var nombre = $('#nombre').val();
    var descripcion = $('#descripcion').val();
    var proveedor = $('#proveedor').val();
    var cantidad = $('#cantidad').val();
    var unidad = $('#unidad').val();
    var valoringreso = $('#valoringreso').val();
    var valorVenta = $('#valorVenta').val();

    if( serial != '' && nombre != '' && proveedor != '' && cantidad != '' & unidad != '' & valoringreso != '' & valorVenta != ''){
       
        $.ajax({
            url:"../../controller/ProductController.php?f=updateproduct" ,
            method: 'POST',
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function(data){
                console.log(data)
                $('#formularioProd')[0].reset();
                $('#modalProd').modal('hide');
                Swal.fire({
                title: "Exito",
                text: "¡Producto creado con exito!",
                icon: "success",
            });
            dataTableProd.ajax.reload();
            },
        });
    }else{
        alert('Todos los campos son obligatorios');
    }
});

$(document).on('click', '.editarProd', function(){    
    var id_prod = $(this).attr("id");
    $.ajax({
        url:"../../controller/ProductController.php?f=vieweditproduct",
        method: "POST",
        data: {id_prod: id_prod},
        datatype: "json",
        success: function(response){
            let datos = JSON.parse(response);
            $("#modalProd").modal('show');
            $(".modal-title").text("Detalles de Producto");
            $("#serial").val(datos[0].serial);
            $("#nombre").val(datos[0].nombre);
            $("#descripcion").val(datos[0].descripcion);
            $("#proveedor").val(datos[0].proveedor);
            $("#cantidad").val(datos[0].cantidad);
            $("#unidad").val(datos[0].unidad);
            $("#valorIngreso").val(datos[0].valorIngreso);
            $("#valorVenta").val(datos[0].valorVenta);
            $("#id_prod").val(id_prod);
            $("#action").val("Editar Producto");
            $("#operation").val("editar");

            if(response == 1){
                Swal.fire({
                    position: "center-center",
                    icon: "success",
                    title: "Producto actualizado con exito",
                    showConfirmButton: false,
                    timer: 1500
                });
            }
            $('#modalProv').modal('hide');
            dataTable.ajax.reload();
        }
    });
});

//---------------------Evento para eliminar un proveedor---------------------//
$(document).on('click', '.borrarProd', function () {
    let id_prod = $(this).attr("id");

    Swal.fire({
        title: "¿Estás seguro?",
        text: "¡Esta acción eliminará el producto seleccionado!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#95bff5",
        cancelButtonColor: "#dc3545",
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "../../controller/ProductController.php?f=deleteproduct",
                method: "POST",
                data: { id_prod: id_prod },
                success: function (response) {
                    if (response == 1) {
                        Swal.fire({
                            icon: "success",
                            title: "¡Producto eliminado con éxito!",
                            showConfirmButton: false,
                            timer: 1000
                        });
                        dataTable.ajax.reload();
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Error al eliminar el producto",
                            text: "Intenta nuevamente o contacta al administrador"
                        });
                    }
                }
            });
        }
    });
});