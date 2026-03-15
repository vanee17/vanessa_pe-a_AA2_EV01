//peticion ajax con jquery al backend para ventas

var dataTableVent = $("#datos_vent").DataTable({
    "processing": true,
    "serverSide": true,
    "order": [],
    "ajax":{
        url: "../../controller/SalesController.php?f=drawsales",
        type: "POST"
    },
    "columns": [
        { "data": "numero_venta" },
        { "data": "fecha_venta" },
        { "data": "id_cliente" },
        { "data": "id_producto" },
        { "data": "cantidad" },
        { "data": "unidad" },
        { "data": "precio_actual" },
        { "data": "precio_venta" },
        { "data": "accion1" },
    ],
    "columnDefs": [
        {
            "targets":[7,8],
            "orderable": false
        }
    ]
});

//---------------------Evento para eliminar una venta---------------------//
$(document).on('click', '.borrarVent', function () {
    let id_vent = $(this).attr("id");

    Swal.fire({
        title: "¿Estás seguro?",
        text: "¡Esta acción eliminará la venta seleccionada!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#95bff5",
        cancelButtonColor: "#dc3545",
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "../../controller/SalesController.php?f=deletesale",
                method: "POST",
                data: { id_vent: id_vent },
                success: function (response) {
                    if (response == 1) {
                        Swal.fire({
                            icon: "success",
                            title: "¡Venta eliminada con éxito!",
                            showConfirmButton: false,
                            timer: 1000
                        });
                        dataTable.ajax.reload();
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Error al eliminar la venta",
                            text: "Intenta nuevamente o contacta al administrador"
                        });
                    }
                }
            });
        }
    });
});