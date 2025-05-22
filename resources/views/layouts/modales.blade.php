<!-- Modal para Crear -->
<div class="modal fade" id="crear" tabindex="-1" aria-labelledby="crearLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="w-100 text-center position-relative">
                    <h1 class="modal-title fs-2 text-primary" id="crearLabel">
                        <i class="fas fa-plus-circle me-2"></i> Crear
                    </h1>
                    <button type="button" class="btn-close position-absolute top-50 end-0 translate-middle-y"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body">
                <!-- Aquí se insertará el formulario dinámicamente -->
            </div>
            <div class="modal-footer">
                <button id="btn-guardar" type="button" class="btn btn-secondary btn-guardar">Guardar</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal-xl" id="crearL" tabindex="-1" aria-labelledby="crearLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="w-100 text-center position-relative">
                    <h1 class="modal-title fs-2 text-primary" id="crearLabel">
                        <i class="fas fa-plus-circle me-2"></i> Crear
                    </h1>
                    <button type="button" class="btn-close position-absolute top-50 end-0 translate-middle-y"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body">
                <!-- Aquí se insertará el formulario dinámicamente -->
            </div>
            <div class="modal-footer">
                <button id="btnL_guardar" type="button" class="btn btn-secondary btn-guardar">Guardar</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
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
                    <h1 class="modal-title fs-2 text-warning" id="editarLabel">
                        <i class="fas fa-edit me-2"></i> Editar
                    </h1>
                    <button type="button" class="btn-close position-absolute top-50 end-0 translate-middle-y"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body">
                <!-- Aquí se insertará el formulario dinámicamente -->
            </div>
            <div class="modal-footer">
                <button id="btn-actualizar" type="button" class="btn btn-secondary btn-actualizar">Actualizar</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Desactivar -->
<div class="modal fade" id="cambiarEstado" tabindex="-1" aria-labelledby="desactivarLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="w-100 text-center position-relative">
                    <h1 class="modal-title fs-2 text-danger" id="desactivarLabel">
                        <i class="fas fa-trash-alt me-2"></i> Desactivar
                    </h1>
                    <button type="button" class="btn-close position-absolute top-50 end-0 translate-middle-y"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body">
                <h3 class="text-black">¿Está seguro de desactivar este registro?</h3>
            </div>
            <div class="modal-footer">
                <button id="btn-desactivar" type="button" class="btn btn-danger btn-desactivar">Desactivar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal para Activar -->
<div class="modal fade" id="activar" tabindex="-1" aria-labelledby="activarLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="w-100 text-center position-relative">
                    <h1 class="modal-title fs-2 text-success" id="activarLabel">
                        <i class="fas fa-check-circle me-2"></i> Activar
                    </h1>
                    <button type="button" class="btn-close position-absolute top-50 end-0 translate-middle-y"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body">
                ¿Está seguro de activar este registro?
            </div>
            <div class="modal-footer">
                <button id="btn-activar" type="button" class="btn btn-success btn-activar">Activar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
