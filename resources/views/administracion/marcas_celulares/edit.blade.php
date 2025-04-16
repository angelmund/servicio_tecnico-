<form id="validar" action="{{ route('MarcasCelularesUpdate',[$marca->id, ''])}}" method="POST" novalidate>
    @csrf
    <div class="mb-3">
        <label for="nombre" class="col-form-label">Marca:</label>
        <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $marca->nombre }}" required minlength="2" maxlength="255">
        <div class="invalid-feedback">
            Por favor, ingresa una marca válida (entre 2 y 255 caracteres).
        </div>
    </div>
    <div class="mb-3">
        <label for="descripcion" class="col-form-label">Descripción:</label>
        <textarea class="form-control" id="descripcion" name="descripcion" required minlength="10" maxlength="500">{{ $marca->descripcion }}</textarea>
        <div class="invalid-feedback">
            La descripción debe tener entre 10 y 500 caracteres.
        </div>
    </div>
</form>
