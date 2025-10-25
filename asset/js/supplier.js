console.log('script suppliers cargado');
//---------------------Localizar el datatable y cargar los datos desde el servidor---------------------//
var dataTable = $("#datos_prov").DataTable({
   "processing": true,
   "serverSide": true,
    "order": [],
   "ajax":{
       url: "../../controller/SupplierController.php?f=drawsuppliers",
       type: "POST"
   },
    "columns": [
        { "data": "nombre_empresa" },
        { "data": "nit" },
        { "data": "direccion" },
        { "data": "telefono" },
        { "data": "contacto_directo" },
        { "data": "telefono_contacto" },
        { "data": "accion1" },
        { "data": "accion2" },
    ],
   "columnDefs": [
       {
           "targets":[6,7],
           "orderable": false
           
       }
   ]
});

//---------------------Evento para limpiar el formulario y preparar la creacion de un nuevo proveedor---------------------//
$('#crearProv').click(function(){
    $('#formularioProv')[0].reset();
    $('#action').val('Crear Proveedor');
    $('#operation').val('create');        
});

//---------------------Evento para capturar los datos del formulario y enviarlos al controlador via ajax---------------------//
$(document).on('submit', '#formularioProv', function(event){
    event.preventDefault();
    let companyName = $('#empresa').val();
    let nit = $('#nit').val();
    let companyAddres = $('#direccion').val();
    let companyPhone = $('#telEmpresa').val();
    let directContact = $('#encargado').val();
    let contactPhone = $('#telEncargado').val();

    if(companyName != '' && nit != '' && companyAddres != '' && companyPhone != '' & directContact != '' & contactPhone != ''){
       
        $.ajax({
            url:"../../controller/SupplierController.php?f=updatesupplier" ,
            method: 'POST',
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function(response){
                let response_data = JSON.parse(response);
                if(response_data.result == 1 && response_data.action == 'create'){
                    Swal.fire({
                        position: "center-center",
                        icon: "success",
                        title: "Proveedor creado con exito",
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
                if(response_data.result == 1 && response_data.action == 'update'){
                      Swal.fire({
                        position: "center-center",
                        icon: "success",
                        title: "Proveedor actualizado con exito",
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
                $('#formularioProv')[0].reset();
                $('#modalProv').modal('hide');
                dataTable.ajax.reload();
            },
        });
    }else{
        alert('Todos los campos son obligatorios');
    }
});

//---------------------Evento para cargar los datos del proveedor a editar---------------------//
$(document).on('click', '.editar', function(){    
    let id_prov = $(this).attr("id");
    $.ajax({
        url:"../../controller/SupplierController.php?f=vieweditsupplier",
        method: "POST",
        data: {id_prov: id_prov},
        datatype: "json",
        success: function(response){
            let datos = JSON.parse(response);
            $("#modalProv").modal('show');
            $("#empresa").val(datos[0].empresa);
            $("#nit").val(datos[0].nit);
            $("#direccion").val(datos[0].direccion);
            $("#telEmpresa").val(datos[0].telEmpresa);
            $("#encargado").val(datos[0].encargado);
            $("#telEncargado").val(datos[0].telEncargado);
            $(".modal-title").text("Editar Proveedor - " + datos[0].empresa);
            $("#id_prov").val(id_prov);
            $("#action").val("Actualizar Proveedor");
            $("#operation").val("update");

            if(response == 1){
                Swal.fire({
                    position: "center-center",
                    icon: "success",
                    title: "Proveedor actualizado con exito",
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
$(document).on('click', '.borrar', function () {
    let id_prov = $(this).attr("id");

    Swal.fire({
        title: "¿Estás seguro?",
        text: "¡Esta acción eliminará el proveedor seleccionado!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#95bff5",
        cancelButtonColor: "#dc3545",
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "../../controller/SupplierController.php?f=deletesupplier",
                method: "POST",
                data: { id_prov: id_prov },
                success: function (response) {
                    if (response == 1) {
                        Swal.fire({
                            icon: "success",
                            title: "¡Proveedor eliminado con éxito!",
                            showConfirmButton: false,
                            timer: 1500
                        });
                        dataTable.ajax.reload();
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Error al eliminar el proveedor",
                            text: "Intenta nuevamente o contacta al administrador"
                        });
                    }
                }
            });
        }
    });
});
