<form id="validar" action="{{ route('estadosReparacionUpdate', ['estado_reparacion' => $estado_reparacion->id]) }}" method="POST" novalidate>
    @csrf
    <div class="mb-3">
        <label for="nombre" class="col-form-label">Nombre estado reparación:</label>
        <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $estado_reparacion->nombre }}" required
            minlength="2" maxlength="255" placeholder="Ej: En proceso">
        <div class="invalid-feedback">
            Por favor, ingresa una estado de reparacion válida (entre 2 y 255 caracteres).
        </div>
    </div>
    <div class="mb-3">
        <label for="descripcion" class="col-form-label">Descripción:</label>
        <textarea class="form-control" id="descripcion" name="descripcion" minlength="2" maxlength="500"
            placeholder="Eje: Entrada equipo para ser diagnosticado">{{ $estado_reparacion->descripcion }}</textarea>
        {{--  <div class="invalid-feedback">
            La descripción debe tener entre 10 y 500 caracteres.
        </div>  --}}
    </div>

</form>
