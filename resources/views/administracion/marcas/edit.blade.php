<form id="validar" action="{{ route('MarcasUpdate', [$marca->id, '']) }}" method="POST" novalidate>
    @csrf
    <div class="mb-3">
        <label for="nombre" class="col-form-label">Marca:</label>
        <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $marca->nombre }}" required
            minlength="2" maxlength="255" placeholder="Ej: Samsung">
        <div class="invalid-feedback">
            Por favor, ingresa una marca válida (entre 2 y 255 caracteres).
        </div>
    </div>
    <div class="mb-3">
        <label for="descripcion" class="col-form-label">Descripción:</label>
        <textarea class="form-control" id="descripcion" name="descripcion" minlength="2" maxlength="500"
            placeholder="Eje: Marca samsung">{{ $marca->descripcion }}</textarea>
        {{--  <div class="invalid-feedback">
            La descripción debe tener entre 10 y 500 caracteres.
        </div>  --}}
    </div>
    <div class="mb-3">
        <label for="logo" class="col-form-label">Logo:</label>
        @if ($marca->logo)
            <img src="{{ asset('storage/' . $marca->logo) }}" alt="Logo" class="img-thumbnail img-fluid mt-2"
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
