let tablaTipoProducto;

function enviarFormulario(formulario) {
    return new Promise((resolve, reject) => {
        const url = formulario.action;
        const formData = new FormData(formulario);

        fetch(url, {
            method: "POST",
            body: formData,
            headers: {
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]'
                ).content,
                Accept: "application/json",
            },
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.message === "Error de validación") {
                    let errorMessage =
                        "Por favor, corrige los siguientes errores:\n";
                    for (let field in data.errors) {
                        errorMessage += `- ${data.errors[field].join(
                            "\n- "
                        )}\n`;
                    }
                    alertarError(errorMessage);
                    reject(new Error(errorMessage));
                } else if (data.Noti == 1) {
                    alertarExito(data.message);
                    agregarRegistroTablaTipoProducto(data);
                    resolve(data);
                } else if (data.Noti == 2) {
                    alertarExito(data.message);
                    actualizarTablaTipoProducto(data);
                    resolve(data);
                } else {
                    alertarInfo(data.message || "Operación completada");
                    actualizarTablaTipoProducto(data);
                    resolve(data);
                }
            })
            .catch((error) => {
                console.error("Error en la petición:", error);
                alertarError("Error en la operación: " + error.message);
                reject(error);
            });
    });
}

//función para agregar el nuevo registro a la tabla
function agregarRegistroTablaTipoProducto(data) {
    const columnConfig = [
        { field: "nombre", type: "text" },
        { field: "descripcion", type: "text" },
        
        { field: "activo", type: "badge", trueValue: true },
        {
            type: "actions",
            routes: {
                create: routes.tiposProductosCreate,
                edit: routes.tiposProductosEdit,
                cambiarEstado : routes.tiposProductoscambiarEstado,
            },
        },
    ];

    nuevoRegistroTabla(data, "datatables", columnConfig);
}

//función para actualizar la tabla con los datos actualizados
function actualizarTablaTipoProducto(data) {
    const columnConfig = [
        { field: "nombre", type: "text" },
        { field: "descripcion", type: "text" },
        
        { field: "activo", type: "badge", trueValue: true },
        {
            type: "actions",
            routes: {
                create: routes.tiposProductosCreate,
                edit: routes.tiposProductosEdit,
                cambiarEstado : routes.tiposProductoscambiarEstado,
            },
        },
    ];

    actualizarTabla(data, "datatables", columnConfig);
}

document.addEventListener("DOMContentLoaded", function () {
    if (!$.fn.DataTable.isDataTable("#datatables")) {
        tablaTipoProducto = initDataTable("datatables");
    } else {
        tablaTipoProducto = $("#datatables").DataTable();
    }

    ["btn-guardar", "btn-actualizar"].forEach((btnId) => {
        const boton = document.getElementById(btnId);
        if (boton) {
            boton.addEventListener("click", function (event) {
                event.preventDefault();

                const formulario = document.getElementById("validar");
                if (!formulario) {
                    alertarError("Formulario no encontrado");
                    return;
                }

                if (validarFormulario(formulario)) {
                    const mensaje =
                        btnId === "btn-guardar"
                            ? "¿Deseas guardar el nuevo registro?"
                            : "¿Deseas actualizar el registro?";

                    mostrarConfirmacion(mensaje, () => {
                        enviarFormulario(formulario)
                            .then((data) => {
                                const modal = formulario.closest(".modal");
                                if (modal) {
                                    const modalInstance =
                                        bootstrap.Modal.getInstance(modal);
                                    if (modalInstance) {
                                        modalInstance.hide();
                                    } else {
                                        console.error(
                                            "No se pudo obtener la instancia del modal"
                                        );
                                    }
                                } else {
                                    console.error("No se encontró el modal");
                                }
                            })
                            .catch((error) => {
                                console.error("Error en la operación:", error);
                            });
                    });
                } else {
                    alertarInfo(
                        "Por favor, completa todos los campos requeridos correctamente."
                    );
                }
            });
        } else {
            console.warn(`Botón #${btnId} no encontrado`);
        }
    });

    ["crear", "editar"].forEach((modalId) => {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.addEventListener("hidden.bs.modal", function () {
                const formulario = this.querySelector("#validar");
                if (formulario) {
                    formulario
                        .querySelectorAll(".form-control")
                        .forEach((input) => {
                            input.classList.remove("is-valid", "is-invalid");
                        });
                }
            });
        }
    });

    // Botón para cambiar el estado de la marca celular

    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('btn-cambiar-estado')) {
            event.preventDefault();
            const id = event.target.getAttribute("data-id");
            const url = event.target.getAttribute("data-url");
            const action = event.target.getAttribute("data-action");
    
            cambiarEstado(id, url, action);
        }
    });

    function cambiarEstado(id, url, action) {
        mostrarConfirmacion(
            `¿Deseas ${action} el tipo de producto?`,
            () => {
                return new Promise((resolve, reject) => {
                    fetch(url, {
                        method: "POST",
                        body: JSON.stringify({ id: id, action: action }),
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector(
                                'meta[name="csrf-token"]'
                            ).content,
                            "Content-Type": "application/json",
                            Accept: "application/json",
                        },
                    })
                        .then((response) => response.json())
                        .then((data) => {
                            if (data.Noti === 1) {
                                alertarExito(data.message);
                                actualizarTablaTipoProducto(data);
                                resolve(data);
                            } else {
                                alertarError(data.message || "Error en la operación");
                                reject(new Error(data.message));
                            }
                        })
                        .catch((error) => {
                            console.error("Error en la petición:", error);
                            alertarError(
                                "Error en la operación: " + error.message
                            );
                            reject(error);
                        });
                });
            }
        );
    }
});
