<form id="validar" action="{{ route('tiposProductosUpdate', ['tipoProducto' => $tipo_producto->id]) }}" method="POST" novalidate>
    @csrf
    <div class="mb-3">
        <label for="nombre" class="col-form-label">Nombre del tipo de producto:</label>
        <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $tipo_producto->nombre }}" required
            minlength="2" maxlength="255" placeholder="Ej. Micas, Pantallas, etc.">
        <div class="invalid-feedback">
            Por favor, ingresa una estado de reparacion válida (entre 2 y 255 caracteres).
        </div>
    </div>
    <div class="mb-3">
        <label for="descripcion" class="col-form-label">Descripción:</label>
        <textarea class="form-control" id="descripcion" name="descripcion" minlength="2" maxlength="500"
            placeholder="Ej: Mica cristal templado">{{ $tipo_producto->descripcion }}</textarea>
        {{--  <div class="invalid-feedback">
            La descripción debe tener entre 10 y 500 caracteres.
        </div>  --}}
    </div>

</form>
