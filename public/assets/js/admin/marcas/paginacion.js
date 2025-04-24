
document.addEventListener("DOMContentLoaded", function () {
    let tablaMarcasCelulares;
    if (!$.fn.DataTable.isDataTable("#datatables")) {
        tablaMarcasCelulares = initDataTable("datatables", {
            processing: true,
            serverSide: true,
            ajax: {
                url: routes.MarcasCelularesIndex,
                type: 'GET'
            },
            columns: [
                {data: 'nombre', name: 'nombre'},
                {data: 'descripcion', name: 'descripcion'},
                {data: 'logo', name: 'logo', 
                 render: function(data, type, full, meta) {
                     if (data) {
                         return "<img src='/storage/" + data + "' alt='Logo' class='img-thumbnail img-fluid' style='max-width: 80px; max-height: 80px;'>";
                     } else {
                         return "<span class='badge badge-secondary'>Sin logo</span>";
                     }
                 }
                },
                {data: 'activo', name: 'activo',
                 render: function(data, type, full, meta) {
                     return data == 1 ? 
                         "<span class='badge badge-success'>Activo</span>" : 
                         "<span class='badge badge-danger'>Inactivo</span>";
                 }
                },
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    } else {
        tablaMarcasCelulares = $("#datatables").DataTable();
    }
});