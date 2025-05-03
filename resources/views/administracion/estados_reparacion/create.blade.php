<style>
    .form-control-color {
        width: 40px !important;
        height: 50px !important;
    }
</style>
<form id="validar" action="{{route('estadosReparacionStore')}}" method="POST" novalidate>
    @csrf
    <div class="mb-3">
        <label for="nombre" class="col-form-label">Nombre del estado de reparación:</label>
        <input type="text" class="form-control" id="nombre" name="nombre" required minlength="2" maxlength="255">
        <div class="invalid-feedback">
            Por favor, ingresa un nombre de estado de reparación válido (entre 2 y 255 caracteres).
        </div>
    </div>
    <div class="mb-3">
        <label for="descripcion" class="col-form-label">Descripción:</label>
        <textarea class="form-control" id="descripcion" name="descripcion"  minlength="2" maxlength="500"></textarea>
        {{--  <div class="invalid-feedback">
            La descripción debe tener entre 10 y 500 caracteres.
        </div>  --}}
    </div>

    {{--  <div class="mb-3">
        <label for="color" class="form-label">Elije un color para este estado de reparación:</label>
        <div class="input-group">
            <input type="color" class="form-control form-control-color color" id="color" name="color" value="#68de0f" title="Elige un color" required>
        </div>
        <div class="invalid-feedback">
            Por favor, selecciona un color para este estado de reparación.
        </div>
    </div>  --}}

</form>