
    <form id="validar" action="{{ route('ordenesReparacionStore') }}" method="POST" novalidate>
        @csrf
        <div class="row">
            <h2 class="text-center text-success">Datos del Equipo</h2>
            <div class="col-md-3 mb-3">
                <label for="numero_orden" class="col-form-label">No.Orden:</label>
                <input type="text" class="form-control" id="numero_orden" name="numero_orden" required readonly
                    value="{{ $nextNumeroOrden }}">
                <div class="invalid-feedback">
                    Por favor, ingresa un número de orden.
                    <small>El número de orden se genera automáticamente.</small>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <label for="tipo_producto_id" class="col-form-label">Tipo de producto:</label>
                <select class="form-control tom-select" id="tipo_producto_id" name="tipo_producto_id" required>
                    <option value="" selected disabled>Elige una opción</option>Selecciona el tipo de producto
                    </option>
                    @foreach ($tipos_productos as $tipos_producto)
                        <option value="{{ $tipos_producto->id }}">{{ $tipos_producto->nombre }}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback">
                    Por favor, selecciona una producto.
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <label for="marca_id" class="col-form-label">Marca:</label>
                <select class="form-control tom-select" id="marca_id" name="marca_id" required>
                    <option value="" selected disabled>Elige una opción</option>Selecciona una marca</option>
                    @foreach ($marcas as $marca)
                        <option value="{{ $marca->id }}">{{ $marca->nombre }}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback">
                    Por favor, selecciona una marca.
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <label for="modelo_producto" class="col-form-label">Modelo:</label>
                <input type="text" class="form-control" id="modelo_producto" name="modelo_producto" required
                    minlength="2" maxlength="255" placeholder="Ej. Samsung Galaxy S21">
                <div class="invalid-feedback">
                    Por favor, ingresa un modelo (entre 2 y 255 caracteres).
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="accesorios" class="col-form-label">Accesorios:</label>
                <textarea class="form-control" id="accesorios" name="accesorios" minlength="2" maxlength="500"
                    placeholder="Ejemplo. Mica cristal templado estrellada"></textarea>
            </div>
            <div class="col-md-6 mb-3">
                <label for="descripcion_falla" class="col-form-label">Descripción de falla:</label>
                <textarea class="form-control" id="descripcion_falla" name="descripcion_falla" minlength="2" maxlength="500"
                    placeholder="Ejemplo. Se cayó al agua y no enciende"></textarea>
            </div>
        </div>

        <div class="row">

            <div class="col-md-3 mb-3">
                <label for="servicio_id" class="col-form-label">Servicio:</label>
                <select class="form-control tom-select" id="servicio_id" name="servicio_id" required>
                    <option value="" selected disabled>Seleccione un servicio</option>
                    @foreach ($servicios as $servicio)
                        <option value="{{ $servicio->id }}" data-precio="{{ $servicio->precio }}">{{ $servicio->nombre }} --
                            ${{ $servicio->precio }}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback">
                    Por favor, selecciona un servicio.
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <label for="costo_reparacion" class="col-form-label">Costo del servicio:</label>
                <input type="number" class="form-control" id="costo_reparacion" name="costo_reparacion" required
                    placeholder="$0.00" step="0.01" min="0" readonly>
                <div class="invalid-feedback">
                    Por favor, ingresa un costo de servicio.
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <label for="fecha_ingreso" class="col-form-label">Fecha de recepción:</label>
                <input type="date" class="form-control" id="fecha_ingreso" name="fecha_ingreso" required
                    value="{{ date('Y-m-d') }}" disabled readonly>
                <div class="invalid-feedback">
                    Por favor, selecciona una fecha de recepción.
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-3 mb-3">
                <label for="fecha_entrega" class="col-form-label">Fecha de entrega:</label>
                <input type="date" class="form-control" id="fecha_entrega" name="fecha_entrega" required>
                <div class="invalid-feedback">
                    Por favor, selecciona una fecha de recepción.
                </div>
            </div>
        </div>

    </form>


{{--  @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            //obtener el data-precio
            const data_precio = document.querySelector('#servicio_id option:checked').dataset.precio;
            //asignar el valor al input costo_reparacion
            console.log(data_precio);
            document.querySelector('#costo_reparacion').value = data_precio;
        });
    </script>
@endpush  --}}