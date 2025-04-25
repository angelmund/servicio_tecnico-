@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <h4 class="card-title text-center">Servicios</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatables" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Precio</th>
                                    <th>descripci&oacute;n</th>
                                    <th>Logo</th>
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
                                @foreach ($servicios as $servicio)
                                    <tr>
                                        <td>{{ $servicio->nombre }}</td>
                                        <td><span class="badge badge-info fw-bold fs-5">${{ number_format($servicio->precio, 2, '.', ',') }}</span></td>
                                        <td>{{ $servicio->descripcion }}</td>
                                        <td>
                                            @if ($servicio->logo)
                                                <img src="{{ asset('storage/' . $servicio->logo) }}" alt="Logo"
                                                    class="img-thumbnail img-fluid"
                                                    style="max-width: 80px; max-height: 80px;">
                                            @else
                                                <span class="badge badge-secondary">Sin logo</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($servicio->activo == 1)
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
                                                            data-form-url="{{ route('ServiciosCreate') }}">
                                                            <i class="fas fa-plus"></i> Crear
                                                        </a>
                                                        <a class="dropdown-item btn btn-warning btn-editar"
                                                            data-bs-toggle="modal" data-bs-target="#editar"
                                                            data-id="{{ $servicio->id }}"
                                                            data-form-url="{{ route('ServiciosEdit', [$servicio->id, '']) }}">
                                                            <i class="fas fa-edit"></i> Editar
                                                        </a>
                                                        <a class="dropdown-item btn {{ $servicio->activo ? 'btn-danger' : 'btn-success' }} btn-cambiar-estado"
                                                            data-id="{{ $servicio->id }}"
                                                            data-action="{{ $servicio->activo ? 'desactivar' : 'activar' }}"
                                                            data-url="{{ route('ServicioscambiarEstado', $servicio->id) }}">
                                                             <i class="fas fa-{{ $servicio->activo ? 'times-circle' : 'bolt' }}"></i>
                                                             {{ $servicio->activo ? 'Desactivar' : 'Activar' }}
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
    <script src="{{ asset('assets/js/admin/servicios/app.js') }}"></script>
    <script>
        const routes = {
            ServiciosCreate: '{{ route('ServiciosCreate') }}',
            ServiciosEdit: '{{ route('ServiciosEdit', ':id') }}',
            ServicioscambiarEstado: '{{ route('ServicioscambiarEstado', ':id') }}'
        };
    </script>
    {{--  <script src="{{ asset('assets/js/admin/servicios_celulares/paginacion.js') }}"></script>  --}}
@endpush
