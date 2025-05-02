@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <h4 class="card-title text-center">Usuarios</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatables" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Correo</th>
                                    <th>Rol</th>
                                    <th>Foto de perfil</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($usuarios as $usuario)
                                    @if (auth()->user()->hasRole('Super Administrador') || !$usuario->hasRole('Super Administrador'))
                                        <tr>
                                            <td>{{ $usuario->name }}</td>
                                            <td>{{ $usuario->email }}</td>
                                            <td>
                                                @if ($usuario->roles->isNotEmpty())
                                                    @foreach ($usuario->roles as $role)
                                                        @if (auth()->user()->hasRole('Super Administrador') || $role->name != 'Super Administrador')
                                                            <span
                                                                class="badge badge-{{ $role->name == 'Super Administrador' ? 'primary' : ($role->name == 'Administrador' ? 'success' : ($role->name == 'Técnico' ? 'warning' : ($role->name == 'Vendedor' ? 'info' : 'secondary'))) }}">
                                                                {{ $role->name }}
                                                            </span>
                                                        @endif
                                                    @endforeach
                                                @else
                                                    <span class="badge badge-secondary">Sin rol asignado</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($usuario->profile_photo_path)
                                                    <img src="{{ asset('storage/' . $usuario->profile_photo_path) }}"
                                                        alt="Foto de {{ $usuario->name }}" class="img-thumbnail img-fluid"
                                                        style="max-width: 80px; max-height: 80px;">
                                                @else
                                                    <span class="badge badge-secondary">Sin foto</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($usuario->activo == 1)
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
                                                        @if (auth()->user()->hasRole('Super Administrador') || !$usuario->hasRole('Super Administrador'))
                                                            <li>
                                                                <a class="dropdown-item btn btn-info btn-crear"
                                                                    data-bs-toggle="modal" data-bs-target="#crear"
                                                                    data-form-url="{{ route('usuariosCreate') }}">
                                                                    <i class="fas fa-plus"></i> Crear
                                                                </a>
                                                                <a class="dropdown-item btn btn-warning btn-editar"
                                                                    data-bs-toggle="modal" data-bs-target="#editar"
                                                                    data-id="{{ $usuario->id }}"
                                                                    data-form-url="{{ route('usuariosEdit', [$usuario->id, '']) }}">
                                                                    <i class="fas fa-edit"></i> Editar
                                                                </a>
                                                                <a class="dropdown-item btn {{ $usuario->activo ? 'btn-danger' : 'btn-success' }} btn-cambiar-estado"
                                                                    data-id="{{ $usuario->id }}"
                                                                    data-action="{{ $usuario->activo ? 'desactivar' : 'activar' }}"
                                                                    data-url="{{ route('usuarioscambiarEstado', $usuario->id) }}">
                                                                    <i
                                                                        class="fas fa-{{ $usuario->activo ? 'times-circle' : 'bolt' }}"></i>
                                                                    {{ $usuario->activo ? 'Desactivar' : 'Activar' }}
                                                                </a>
                                                            </li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
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
    <script src="{{ asset('assets/js/admin/usuarios/app.js') }}"></script>
    <script>
        const routes = {
            usuariosCreate: '{{ route('usuariosCreate') }}',
            usuariosEdit: '{{ route('usuariosEdit', ':id') }}',
            usuarioscambiarEstado: '{{ route('usuarioscambiarEstado', ':id') }}'
        };
    </script>
@endpush
