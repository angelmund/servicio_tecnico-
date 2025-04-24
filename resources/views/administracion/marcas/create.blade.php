<form id="validar" action="{{route('MarcasStore')}}" method="POST" novalidate>
    @csrf
    <div class="mb-3">
        <label for="nombre" class="col-form-label">Marca:</label>
        <input type="text" class="form-control" id="nombre" name="nombre" required minlength="2" maxlength="255" placeholder="Ej: Samsung">
        <div class="invalid-feedback">
            Por favor, ingresa una marca válida (entre 2 y 255 caracteres).
        </div>
    </div>
    <div class="mb-3">
        <label for="descripcion" class="col-form-label">Descripción:</label>
        <textarea class="form-control" id="descripcion" name="descripcion"  minlength="2" maxlength="500"></textarea>
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

