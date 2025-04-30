<form id="validar" action="{{ route('estadosVentaStore')}}" method="POST" novalidate>
    @csrf
    <div class="mb-3">
        <label for="nombre" class="col-form-label">Nombre del estado de venta:</label>
        <input type="text" class="form-control" id="nombre" name="nombre" required minlength="2" maxlength="255" placeholder="Ej. En espera.">
        <div class="invalid-feedback">
            Por favor, ingresa un nombre del estado de venta (entre 2 y 255 caracteres).
        </div>
    </div>
    <div class="mb-3">
        <label for="descripcion" class="col-form-label">Descripción:</label>
        <textarea class="form-control" id="descripcion" name="descripcion"  minlength="2" maxlength="500" placeholder="Ejemplo. Venta en espera de pago o confirmación"></textarea>
        {{--  <div class="invalid-feedback">
            La descripción debe tener entre 10 y 500 caracteres.
        </div>  --}}
    </div>

</form>

