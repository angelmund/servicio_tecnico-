@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <h4 class="card-title text-center">Ordenes de Reparaci&oacute;n</h4>
                    {{--  <a href="{{ route('ordenesReparacionCreate') }}"><button type="button" class="btn btn-primary float-right">Agregar Nueva Orden</button></a>  --}}
                    <a type="button"  data-bs-toggle="modal" data-bs-target="#crearL"
                        data-form-url="{{ route('ordenesReparacionCreate') }}" class="btn btn-primary float-right btn-crear">
                        <i class="fas fa-plus"></i> Agregar Nueva Orden
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatables" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No. Orden</th>
                                    <th>Marca</th>
                                    <th>Modelo</th>
                                    <th>Descripci&oacute;n falla</th>
                                    <th>Servicio</th>
                                    <th>Costo</th>
                                    <th>Estado reparaci&oacute;n</th>
                                    <th>Fecha de ingreso</th>
                                    <th>Fecha de entrega</th>
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
                                @foreach ($ordenes_reparacion as $orden_reparacion)
                                    <tr>
                                        <td>{{ $orden_reparacion->numero_orden }}</td>
                                        <td>{{ $orden_reparacion->marcaProducto }}</td>
                                        <td>{{ $orden_reparacion->modelo_producto }}</td>
                                        <td>{{ $orden_reparacion->descripcion_falla }}</td>
                                        <td>{{ $orden_reparacion->servicio }}</td>
                                        <td>{{ $orden_reparacion->servicio->precio }}</td>
                                        <td>{{ $orden_reparacion->estadoReparacion }}</td>
                                        <td>{{ $orden_reparacion->fecha_ingreso }}</td>
                                        <td>{{ $orden_reparacion->fecha_entrega }}</td>
                                        <td>
                                            @if ($orden_reparacion->activo == 1)
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
                                                        {{--  <a class="dropdown-item btn btn-info btn-crear"
                                                            data-bs-toggle="modal" data-bs-target="#crear"
                                                            data-form-url="{{ route('ordenesReparacionCreate') }}">
                                                            <i class="fas fa-plus"></i> Crear
                                                        </a>  --}}
                                                        <a class="dropdown-item btn btn-warning btn-editar"
                                                            data-bs-toggle="modal" data-bs-target="#editar"
                                                            data-id="{{ $orden_reparacion->id }}"
                                                            data-form-url="{{ route('ordenesReparacionEdit', ['id' => $orden_reparacion->id]) }}">
                                                            <i class="fas fa-edit"></i> Editar
                                                        </a>
                                                        {{--  <a class="dropdown-item btn {{ $orden_reparacion->activo ? 'btn-danger' : 'btn-success' }} btn-cambiar-estado"
                                                            data-id="{{ $orden_reparacion->id }}"
                                                            data-action="{{ $orden_reparacion->activo ? 'desactivar' : 'activar' }}"
                                                            data-url="{{ route('estadosReparacioncambiarEstado', $orden_reparacion->id) }}">
                                                            <i
                                                                class="fas fa-{{ $orden_reparacion->activo ? 'times-circle' : 'bolt' }}"></i>
                                                            {{ $orden_reparacion->activo ? 'Desactivar' : 'Activar' }}
                                                        </a>  --}}
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
    <script src="{{ asset('assets/js/admin/ordenes_reparacion/app.js') }}"></script>
    <script>
        const routes = {
            //estadosReparacionCreate: '{{ route('estadosReparacionCreate') }}',
            estadosReparacionEdit: '{{ route('estadosReparacionEdit', ['id' => ':id']) }}',
            //estadosReparacioncambiarEstado: '{{ route('estadosReparacioncambiarEstado', ['id' => ':id']) }}'
        };
    </script>
@endpush
