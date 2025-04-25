<form id="validar" action="{{ route('ServiciosUpdate', [$Servicio->id, '']) }}" method="POST" novalidate>
    @csrf
    <div class="mb-3">
        <label for="nombre" class="col-form-label">Nombre del servicio:</label>
        <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $Servicio->nombre }}" required
            minlength="2" maxlength="255" placeholder="Ej: Cambio de pantalla">
            <div class="invalid-feedback">
                Por favor, ingresa un nombre de servicio válido (entre 2 y 255 caracteres).
            </div>
    </div>
    <div class="mb-3">
        <label for="nombre" class="col-form-label">Precio:</label>
        <input type="number" class="form-control" id="precio" name="precio" required min="1" step="0.01" value="{{ $Servicio->precio }}" placeholder="Ej: 150.00">
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
        <textarea class="form-control" id="descripcion" name="descripcion" minlength="2" maxlength="500"
            placeholder="Eje: Marca samsung">{{ $Servicio->descripcion }}</textarea>
        {{--  <div class="invalid-feedback">
            La descripción debe tener entre 10 y 500 caracteres.
        </div>  --}}
    </div>
    <div class="mb-3">
        <label for="logo" class="col-form-label">Logo:</label>
        @if ($Servicio->logo)
            <img src="{{ asset('storage/' . $Servicio->logo) }}" alt="Logo" class="img-thumbnail img-fluid mt-2"
                style="max-width: 80px; max-height: 80px;">
            <label for="file" class="col-form-label">Cambiar:</label>
            <input type="file" class="form-control" id="logo" name="logo" accept=".jpg, .jpeg, .png">
        @else
            <span class="badge badge-secondary">Sin logo</span>
            <br>
            <label for="file" class="col-form-label">Para subir un logo, selecciona un archivo.</label>
            <input type="file" class="form-control" id="logo" name="logo" accept=".jpg, .jpeg, .png">
        @endif
        <div class="invalid-feedback">
            Por favor, selecciona un logo válido (formato .jpg, .jpeg o .png).
        </div>
    </div>
</form>
