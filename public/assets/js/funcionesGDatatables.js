function formateoMoneda(precio) {
    const numero = parseFloat(precio);
    if (!isNaN(numero)) {
        return new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' }).format(numero);
    }
    return 'N/A';
}

// Función para actualizar la tabla DataTables
// Esta función toma los datos y la configuración de columnas para actualizar la tabla
function nuevoRegistroTabla(data, tableId, columnConfig = []) {
    // Intentamos obtener los datos del objeto, asumiendo que pueden estar en una propiedad
    const datos = data[Object.keys(data).find(key => typeof data[key] === 'object')] || data;

    if (!datos || !datos.id) {
        console.error("No se recibieron datos válidos");
        return;
    }

    if (columnConfig.length === 0) {
        console.error("No se recibió configuración de columnas");
        return;
    }

    const table = $(`#${tableId}`).DataTable();
    
    const rowData = columnConfig.map(column => {
        switch (column.type) {
            case 'text':
                return datos[column.field] || '';
            case 'moneda':
                return `<span class="badge badge-info fw-bold fs-5">${formateoMoneda(datos[column.field])}</span>`;
            case 'rol':
                return getRoleBadge(datos[column.field]);
            case 'image':
                return datos[column.field]
                    ? `<img src="${datos[column.field].startsWith("http") ? datos[column.field] : `/storage/${datos[column.field]}`}" alt="${datos[column.altField] || ''}" class="img-thumbnail img-fluid" style="max-width: 80px; max-height: 80px;">`
                    : '<span class="badge badge-secondary">Sin imagen</span>';
            case 'badge':
                return datos[column.field] === column.trueValue
                    ? '<span class="badge badge-success">Activo</span>'
                    : '<span class="badge badge-danger">Inactivo</span>';
            case 'actions':
                return generateActionButtons(datos, column.routes);
            default:
                return datos[column.field] || '';
        }
    });

    const existingRow = table.row(`#${columnConfig[0].field}-${datos.id}`);
    if (existingRow.length) {
        existingRow.data(rowData).draw();
    } else {
        const newRow = table.row.add(rowData).draw().node();
        $(newRow).attr('id', `${columnConfig[0].field}-${datos.id}`);
    }
}
//actualizar Tabla con datos actualizados
function actualizarTabla(data, tableId, columnConfig = []) {
    const datos = data[Object.keys(data).find(key => typeof data[key] === 'object')] || data;

    if (!datos || !datos.id) {
        console.error("No se recibieron datos válidos");
        return;
    }

    if (columnConfig.length === 0) {
        console.error("No se recibió configuración de columnas");
        return;
    }

    const table = $(`#${tableId}`).DataTable();
    
    const rowData = columnConfig.map(column => {
        switch (column.type) {
            case 'text':
                return datos[column.field] || '';
            case 'moneda':
                return `<span class="badge badge-info fw-bold fs-5">${formateoMoneda(datos[column.field])}</span>`;
            case 'rol':
                return getRoleBadge(datos[column.field]);
            case 'image':
                return datos[column.field]
                    ? `<img src="${datos[column.field].startsWith("http") ? datos[column.field] : `/storage/${datos[column.field]}`}" alt="${datos[column.altField] || ''}" class="img-thumbnail img-fluid" style="max-width: 80px; max-height: 80px;">`
                    : '<span class="badge badge-secondary">Sin imagen</span>';
            case 'badge':
                return datos[column.field] === column.trueValue
                    ? '<span class="badge badge-success">Activo</span>'
                    : '<span class="badge badge-danger">Inactivo</span>';
            case 'actions':
                return generateActionButtons(datos, column.routes);
            default:
                return datos[column.field] || '';
        }
    });

    // Buscar la fila existente por ID
    const existingRowIndex = table.rows().indexes().filter(index => {
        const rowNode = table.row(index).node();
        return $(rowNode).find('[data-id]').data('id') == datos.id;
    });

    if (existingRowIndex.length > 0) {
        // Actualizar la fila existente
        table.row(existingRowIndex[0]).data(rowData).draw(false);
    } else {
        // Agregar una nueva fila
        table.row.add(rowData).draw(false);
    }
}
// Function para generar acciones de la tabla, como crear, editar y eliminar
function generateActionButtons(data, routes) {
    return `
        <div class="btn-group dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                Acciones
            </button>
            <ul class="dropdown-menu" role="menu">
                <li>
                    <a class="dropdown-item btn btn-info btn-crear" data-bs-toggle="modal" data-bs-target="#crear" data-form-url="${routes.create}">
                        <i class="fas fa-plus"></i> Crear
                    </a>
                    <a class="dropdown-item btn btn-warning btn-editar" data-bs-toggle="modal" data-bs-target="#editar" data-id="${data.id}" data-form-url="${routes.edit.replace(':id', data.id)}">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                    <a class="dropdown-item btn ${data.activo ? 'btn-danger' : 'btn-success'} btn-cambiar-estado"
                       data-id="${data.id}"
                       data-action="${data.activo ? 'desactivar' : 'activar'}"
                       data-url="${routes.cambiarEstado.replace(':id', data.id)}">
                        <i class="fas fa-${data.activo ? 'times-circle' : 'bolt'}"></i>
                        ${data.activo ? 'Desactivar' : 'Activar'}
                    </a>
                </li>
            </ul>
        </div>
    `;
}

//Function para generar rutas utilizando Laravel Route::resource()
function generarRutas(modulo) {
    return {
        create: route(`${modulo}Create`),
        edit: route(`${modulo}Edit`, ":id"),
        delete: route(`${modulo}Delete`, ":id")
    };
}

// Función auxiliar para generar el badge del rol
function getRoleBadge(roleName) {
    const roleBadges = {
        'Super Administrador': 'primary',
        'Administrador': 'success',
        'Técnico': 'warning',
        'Vendedor': 'info'
    };

    const badgeClass = roleBadges[roleName] || 'secondary';
    return `<span class="badge badge-${badgeClass}">${roleName || 'Sin rol asignado'}</span>`;
}
