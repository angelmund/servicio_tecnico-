<!-- Modal para Crear -->
<div class="modal fade" id="crear" tabindex="-1" aria-labelledby="crearLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="w-100 text-center position-relative">
                    <h1 class="modal-title fs-2 text-primary" id="crearLabel">Crear</h1>
                    <button type="button" class="btn-close position-absolute top-50 end-0 translate-middle-y"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body">
                <!-- Aquí se insertará el formulario dinámicamente -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                <button id="btn-guardar" type="button" class="btn btn-secondary btn-guardar">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Editar -->
<div class="modal fade" id="editar" tabindex="-1" aria-labelledby="editarLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="w-100 text-center position-relative">
                    <h1 class="modal-title fs-2 text-warning" id="editarLabel">Editar</h1>
                    <button type="button" class="btn-close position-absolute top-50 end-0 translate-middle-y"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body">
                <!-- Aquí se insertará el formulario dinámicamente -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                <button id="btn-actualizar" type="button" class="btn btn-secondary btn-actualizar">Actualizar</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal para Eliminar -->
<div class="modal fade" id="eliminar" tabindex="-1" aria-labelledby="eliminarLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div свої="w-100 text-center position-relative">
                    <h1 class="modal-title fs-2 text-danger" id="eliminarLabel">Eliminar</h1>
                    <button type="button" class="btn-close position-absolute top-50 end-0 translate-middle-y"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body">
                ¿Estás seguro de que deseas eliminar este registro?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="form-eliminar" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>