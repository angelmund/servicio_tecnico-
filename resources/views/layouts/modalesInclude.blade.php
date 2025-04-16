<!-- layouts/modales_modulo.blade.php -->
@push('modals')
    <!-- Modal para Crear -->
    @include('layouts.modales', [
        'id' => $createId ?? 'crear',
        'title' => $createTitle ?? 'Crear',
        'titleClass' => $createTitleClass ?? 'text-primary',
        'slot' => view($createFormView)
    ])

    <!-- Modal para Editar -->
    @include('layouts.modales', [
        'id' => $editId ?? 'editar',
        'title' => $editTitle ?? 'Editar',
        'titleClass' => $editTitleClass ?? 'text-warning',
        'slot' => view($editFormView)
    ])
@endpush