<form id="validar" action="{{route('tiposProductosStore')}}" method="POST" novalidate>
    @csrf
    <div class="mb-3">
        <label for="nombre" class="col-form-label">Nombre del tipo de producto:</label>
        <input type="text" class="form-control" id="nombre" name="nombre" required minlength="2" maxlength="255" placeholder="Ej. Micas, Pantallas, etc.">
        <div class="invalid-feedback">
            Por favor, ingresa un nombre del tipo de producto (entre 2 y 255 caracteres).
        </div>
    </div>
    <div class="mb-3">
        <label for="descripcion" class="col-form-label">Descripción:</label>
        <textarea class="form-control" id="descripcion" name="descripcion"  minlength="2" maxlength="500" placeholder="Ejemplo. Mica cristal templado"></textarea>
        {{--  <div class="invalid-feedback">
            La descripción debe tener entre 10 y 500 caracteres.
        </div>  --}}
    </div>

</form>

