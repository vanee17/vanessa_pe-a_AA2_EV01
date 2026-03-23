//---------------------Localizar el datatable y cargar los datos desde el servidor---------------------//
var dataTable = $("#datos_user").DataTable({
   "processing": true,
   "serverSide": true,
    "order": [],
   "ajax":{
       url: "../../controller/UserController.php?f=drawallusers",
       type: "POST"
   },

    "columns": [
        { "data": "nombre" },
        { "data": "numero_documento" },
        { "data": "correo" },
        { "data": "rol" },
        { "data": "usuario" },
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

//---------------------Evento para limpiar el formulario y preparar la creacion de un nuevo usuario---------------------//
$('#crearUser').click(function(){
    $('#formularioUser')[0].reset();
    $('#action').val('Crear Usuario');
    $('#operation').val('create');        
});

//---------------------Evento para capturar los datos del formulario y enviarlos al controlador via ajax---------------------//
$(document).on('submit', '#formularioUser', function(event){
    event.preventDefault();
    let Name = $('#nombre').val();
    let number_document = $('#numero_documento').val();
    let email = $('#correo').val();
    let rol = $('#rol').val();
    let user = $('#usuario').val();
    let password = $('#clave').val();

    if(Name != '' && number_document != '' && email != '' && rol != '' && user != '' && password != ''){
       
        $.ajax({
            url:"../../controller/UserController.php?f=updateusers" ,
            method: 'POST',
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function(response){
                console.log(response);
                let response_data = {};
                try{
                    response_data = JSON.parse(response);
                } catch(e){
                    console.error('Invalid JSON response:', response);
                    Swal.fire({icon: 'error', title: 'Error', text: 'Respuesta inválida del servidor'});
                    return;
                }

                if(response_data.result == 1 && response_data.action == 'create'){
                    Swal.fire({position: "center-center", icon: "success", title: "Usuario creado con exito", showConfirmButton: false, timer: 1500});
                } else if(response_data.result == 1 && response_data.action == 'update'){
                    Swal.fire({position: "center-center", icon: "success", title: "Usuario actualizado con exito", showConfirmButton: false, timer: 1500});
                } else if(response_data.result == 0) {
                    let msg = response_data.message || 'Ocurrió un error';
                    Swal.fire({icon: 'error', title: 'Error', text: msg});
                }

                $('#formularioUser')[0].reset();
                $('#modalUser').modal('hide');
                dataTable.ajax.reload();
            },
        });
    }else{
        alert('Todos los campos son obligatorios');
    }
});

//---------------------Evento para cargar los datos del usuario a editar---------------------//
$(document).on('click', '.editar', function(){    
    let id_user = $(this).attr("id");
    $.ajax({
        url:"../../controller/UserController.php?f=viewedituser",
        method: "POST",
        data: {id_user: id_user},
        datatype: "json",
        success: function(response){
            let datos = JSON.parse(response);
            $("#modalUser").modal('show');
            $("#nombre").val(datos[0].nombre);
            $("#numero_documento").val(datos[0].numero_documento);
            $("#correo").val(datos[0].correo);
            $("#rol").val(datos[0].rol);
            $("#usuario").val(datos[0].usuario);
            $("#clave").val('');
            $("#id_user").val(id_user);
            $("#action").val("Actualizar Usuario");
            $("#operation").val("update");

            if(response == 1){
                Swal.fire({
                    position: "center-center",
                    icon: "success",
                    title: "Usuario actualizado con exito",
                    showConfirmButton: false,
                    timer: 1500
                });
            }
            $('#modalUser').modal('hide');
            dataTable.ajax.reload();
        }
    });
});

//---------------------Evento para eliminar un usuario---------------------//
$(document).on('click', '.borrar', function () {
    let id_user = $(this).attr("id");

    Swal.fire({
        title: "¿Estás seguro?",
        text: "¡Esta acción eliminará el usuario seleccionado!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#95bff5",
        cancelButtonColor: "#dc3545",
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "../../controller/UserController.php?f=deleteuser",
                method: "POST",
                data: { id_user: id_user },
                success: function (response) {
                    if (response == 1) {
                        Swal.fire({
                            icon: "success",
                            title: "¡Usuario eliminado con éxito!",
                            showConfirmButton: false,
                            timer: 1500
                        });
                        dataTable.ajax.reload();
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Error al eliminar el usuario",
                            text: "Intenta nuevamente o contacta al administrador"
                        });
                    }
                }
            });
        }
    });
});
