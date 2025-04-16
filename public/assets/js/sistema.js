function validarFormulario(formulario) {
    let esValido = true;

    // Limpia las clases de validación previas
    formulario.querySelectorAll('.form-control').forEach(input => {
        input.classList.remove('is-valid', 'is-invalid');
    });

    // Valida cada campo
    formulario.querySelectorAll('input, textarea, select').forEach(input => {
        if (!input.checkValidity()) {
            input.classList.add('is-invalid');
            esValido = false;
        } else {
            input.classList.add('is-valid');
        }
    });

    return esValido;
}


// Función para mostrar SweetAlert2 y ejecutar el callback si se confirma
function mostrarConfirmacion(mensaje, callback) {
    Swal.fire({
        title: 'Confirmación',
        text: mensaje,
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#6861CE',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, continuar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            callback();
        }
    });
}

//alertar de error
function alertarError(mensaje) {
    Swal.fire({
        title: 'Error',
        text: mensaje,
        icon: 'error',
        confirmButtonText: 'Aceptar'
    });
}

function alertarExito(mensaje) {
    Swal.fire({
        title: 'Éxito',
        text: mensaje,
        icon: 'success',
        confirmButtonText: 'Aceptar'
    });
}

function alertarInfo(mensaje) {
    Swal.fire({
        title: 'Alerta',
        text: mensaje,
        icon: 'info',
        confirmButtonText: 'Aceptar'
    });
}