@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <h4 class="card-title text-center">Tipos de productos</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatables" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>descripci&oacute;n</th>
                                    <th>Estado</th>
                                    <th></th>
                                </tr>
                            </thead>
                            {{--  <tfoot>
                                <tr>
                                    <th>Nombre</th>
                                    <th>descripci&oacute;n</th>
                                    <th>Activo</th>
                                    <th>Acciones</th>
                                </tr>
                            </tfoot>  --}}
                            <tbody>
                                @foreach ($tipos_producto as $tipo_producto)
                                    <tr>
                                        <td>{{ $tipo_producto->nombre }}</td>
                                        <td>{{ $tipo_producto->descripcion }}</td>
                                        <td>
                                            @if ($tipo_producto->activo == 1)
                                                <span class="badge badge-success">Activo</span>
                                            @else
                                                <span class="badge badge-danger">Inactivo</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group dropdown">
                                                <button class="btn btn-secondary dropdown-toggle" type="button"
                                                    data-bs-toggle="dropdown">
                                                    Acciones
                                                </button>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li>
                                                        <a class="dropdown-item btn btn-info btn-crear"
                                                            data-bs-toggle="modal" data-bs-target="#crear"
                                                            data-form-url="{{ route('tiposProductosCreate') }}">
                                                            <i class="fas fa-plus"></i> Crear
                                                        </a>
                                                        <a class="dropdown-item btn btn-warning btn-editar"
                                                            data-bs-toggle="modal" data-bs-target="#editar"
                                                            data-id="{{ $tipo_producto->id }}"
                                                            data-form-url="{{ route('tiposProductosEdit', $tipo_producto->id) }}">
                                                            <i class="fas fa-edit"></i> Editar
                                                        </a>
                                                        <a class="dropdown-item btn {{ $tipo_producto->activo ? 'btn-danger' : 'btn-success' }} btn-cambiar-estado"
                                                            data-id="{{ $tipo_producto->id }}"
                                                            data-action="{{ $tipo_producto->activo ? 'desactivar' : 'activar' }}"
                                                            data-url="{{ route('tiposProductoscambiarEstado', $tipo_producto->id) }}">
                                                             <i class="fas fa-{{ $tipo_producto->activo ? 'times-circle' : 'bolt' }}"></i>
                                                             {{ $tipo_producto->activo ? 'Desactivar' : 'Activar' }}
                                                         </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script src="{{ asset('assets/js/admin/tipoProductos/app.js') }}"></script>
    <script>
        const routes = {
            tiposProductosCreate: '{{ route('tiposProductosCreate') }}',
            tiposProductosEdit: '{{ route('tiposProductosEdit', ':id') }}',
            tiposProductoscambiarEstado: '{{ route('tiposProductoscambiarEstado', ':id') }}'
        };
    </script>
@endpush
