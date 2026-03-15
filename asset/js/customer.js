//peticion ajax con jquery al backend para productos

console.log("CARGUE DE SCRIPT DE CLIENTE");

var dataTableClient = $("#datos_client").DataTable({
    "processing": true,
    "serverSide": true,
    "order": [],
    "ajax":{
        url: "../../controller/CustomerController.php?f=drawcustomers",
        type: "POST",
        dataType: 'json',
        error: function (jqXHR, textStatus, errorThrown) {
            console.error('DataTables JSON inválido — respuesta cruda:', jqXHR.responseText);
            alert('Error: JSON inválido. Revisa la consola (Network -> Response).');
        }
    },
    "columns": [
        { "data": "nombre" },
        { "data": "documento" },
        { "data": "direccion" },
        { "data": "telefono" },
        { "data": "correo_electronico" },
        { "data": "accion1" },
        { "data": "accion2" },
    ],
    "columnDefs": [
        {
            "targets":[5,6],
            "orderable": false
        }
    ]
});

 //funcionalidad crear cliente     
 $('#crearClient').click(function(){
     $('#formularioClient')[0].reset();
     $('#action').val('Crear Cliente');
     $('#operation').val('crear');
 });

$(document).on('submit', '#formularioClient', function(event){
    event.preventDefault();
    var nombre = $('#nombre').val();
    var documento = $('#documento').val();
    var direccion = $('#direccion').val();
    var telefono = $('#telefono').val();
    var correo = $('#correo').val();

    if( nombre != '' && documento != '' && direccion != '' && telefono != '' && correo != ''){
       
        $.ajax({
            url:"../../controller/CustomerController.php?f=updatecustomer" ,
            method: 'POST',
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function(data){
                console.log(data)
                $('#formularioClient')[0].reset();
                $('#modalClient').modal('hide');
                Swal.fire({
                title: "Exito",
                text: "¡Cliente creado con exito!",
                icon: "success",
            });
            dataTableClient.ajax.reload();
            },
        });
    }else{
        alert('Todos los campos son obligatorios');
    }
});

$(document).on('click', '.editarClient', function(){    
    var id_cliente = $(this).attr("id");
    $.ajax({
        url:"../../controller/CustomerController.php?f=vieweditcustomer",
        method: "POST",
        data: {id_cliente: id_cliente},
        datatype: "json",
        success: function(response){
            let datos = JSON.parse(response);
            $("#modalClient").modal('show');
            $(".modal-title").text("Detalles de Cliente");
            $("#id_cliente").val(datos[0].id_cliente);
            $("#nombre").val(datos[0].nombre);
            $("#documento").val(datos[0].documento);
            $("#direccion").val(datos[0].direccion);
            $("#telefono").val(datos[0].telefono);
            $("#correo").val(datos[0].correo);
            $("#action").val("Editar Cliente");
            $("#operation").val("editar");

            if(response == 1){
                Swal.fire({
                    position: "center-center",
                    icon: "success",
                    title: "Cliente actualizado con exito",
                    showConfirmButton: false,
                    timer: 1500
                });
            }
            $('#modalClient').modal('hide');
            dataTableClient.ajax.reload();
        }
    });
});

//---------------------Evento para eliminar un proveedor---------------------//
$(document).on('click', '.borrarClient', function () {
    let id_cliente = $(this).attr("id");

    Swal.fire({
        title: "¿Estás seguro?",
        text: "¡Esta acción eliminará el cliente seleccionado!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#95bff5",
        cancelButtonColor: "#dc3545",
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "../../controller/CustomerController.php?f=deletecustomer",
                method: "POST",
                data: { id_cliente: id_cliente },
                success: function (response) {
                    if (response == 1) {
                        Swal.fire({
                            icon: "success",
                            title: "¡Cliente eliminado con éxito!",
                            showConfirmButton: false,
                            timer: 1000
                        });
                        dataTableClient.ajax.reload();
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Error al eliminar el cliente",
                            text: "Intenta nuevamente o contacta al administrador"
                        });
                    }
                }
            });
        }
    });
});