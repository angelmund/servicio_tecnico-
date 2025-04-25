<form id="validar" action="{{route('ServiciosStore')}}" method="POST" novalidate>
    @csrf
    <div class="mb-3">
        <label for="nombre" class="col-form-label">Nombre del servicio:</label>
        <input type="text" class="form-control" id="nombre" name="nombre" required minlength="2" maxlength="255" placeholder="Ej: Cambio de pantalla">
        <div class="invalid-feedback">
            Por favor, ingresa un nombre de servicio válido (entre 2 y 255 caracteres).
        </div>
    </div>
    <div class="mb-3">
        <label for="nombre" class="col-form-label">Precio:</label>
        <input type="number" class="form-control" id="precio" name="precio" required min="1" step="0.01" placeholder="Ej: 150.00">
        <div class="invalid-feedback">
            Por favor, ingresa un precio válido (mínimo 1).
            <small>Formato decimal con dos decimales.</small>
            <small>Ejemplo: 150.00</small>
            <small>Rango: 0 a 999999.99</small>
            <small>Formato de moneda: $150.00</small>
        </div>
    </div>
    <div class="mb-3">
        <label for="descripcion" class="col-form-label">Descripción:</label>
        <textarea class="form-control" id="descripcion" name="descripcion"  minlength="2" maxlength="500" placeholder="Ej. Sustituir por pantalla nueva"></textarea>
        {{--  <div class="invalid-feedback">
            La descripción debe tener entre 10 y 500 caracteres.
        </div>  --}}
    </div>
    <div class="mb-3">
        <label for="logo" class="col-form-label">Logo:</label>
        <input type="file" class="form-control" id="logo" name="logo" accept="image/png, image/jpeg">
        <div class="invalid-feedback">
            Por favor, selecciona una imagen válida.
            <small>Formatos permitidos: JPEG, PNG, GIF.</small>
            <small>Tamaño máximo: 5MB.</small>
            <small>Resolución mínima: 200x200px.</small>
            <small>Dimensiones máximas: 2000x2000px.</small>
            <small>Dimensiones recomendadas: 200x200px.</small>
            <small>Color de fondo: #ffffff.</small>
            <small>Color de texto: #000000.</small>
        </div>
    </div>
</form>

