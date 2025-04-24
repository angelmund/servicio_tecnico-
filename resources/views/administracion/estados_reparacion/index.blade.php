@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <h4 class="card-title text-center">Estados de reparaci&oacute;n</h4>
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
                                @foreach ($estados_reparacion as $estado_reparacion)
                                    <tr>
                                        <td>{{ $estado_reparacion->nombre }}</td>
                                        <td>{{ $estado_reparacion->descripcion }}</td>
                                        <td>
                                            @if ($estado_reparacion->activo == 1)
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
                                                            data-form-url="{{ route('estadosReparacionCreate') }}">
                                                            <i class="fas fa-plus"></i> Crear
                                                        </a>
                                                        <a class="dropdown-item btn btn-warning btn-editar"
                                                            data-bs-toggle="modal" data-bs-target="#editar"
                                                            data-id="{{ $estado_reparacion->id }}"
                                                            data-form-url="{{ route('estadosReparacionEdit', ['id' => $estado_reparacion->id]) }}">
                                                            <i class="fas fa-edit"></i> Editar
                                                        </a>
                                                        <a class="dropdown-item btn {{ $estado_reparacion->activo ? 'btn-danger' : 'btn-success' }} btn-cambiar-estado"
                                                            data-id="{{ $estado_reparacion->id }}"
                                                            data-action="{{ $estado_reparacion->activo ? 'desactivar' : 'activar' }}"
                                                            data-url="{{ route('estadosReparacioncambiarEstado', $estado_reparacion->id) }}">
                                                            <i
                                                                class="fas fa-{{ $estado_reparacion->activo ? 'times-circle' : 'bolt' }}"></i>
                                                            {{ $estado_reparacion->activo ? 'Desactivar' : 'Activar' }}
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
    <script src="{{ asset('assets/js/admin/estados_reparacion/app.js') }}"></script>
    <script>
        const routes = {
            estadosReparacionCreate: '{{ route('estadosReparacionCreate') }}',
            estadosReparacionEdit: '{{ route('estadosReparacionEdit', ['id' => ':id']) }}',
            estadosReparacioncambiarEstado: '{{ route('estadosReparacioncambiarEstado', ['id' => ':id']) }}'
        };
    </script>
@endpush
