<form id="validar" action="{{ route('usuariosUpdate', [$usuario->id, '']) }}" method="POST" novalidate>
    @csrf
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="name" class="col-form-label">Nombre:</label>
            <input type="text" class="form-control" id="name" name="name" required minlength="2" maxlength="255" placeholder="Ej: Juan" value="{{ $usuario->name }}">
            <div class="invalid-feedback">
                Por favor, ingresa una nombre (entre 2 y 255 caracteres).
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <label for="primer_apellido" class="col-form-label">Apellido paterno:</label>
            <input type="text" class="form-control" id="primer_apellido" name="primer_apellido" required minlength="2" maxlength="255" placeholder="Ej: Gómez" value="{{ $usuario->primer_apellido }}">
            <div class="invalid-feedback">
                Por favor, ingresa un apellido válido (entre 2 y 255 caracteres).
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <label for="segundo_apellido" class="col-form-label">Apellido Materno:</label>
            <input type="text" class="form-control" id="segundo_apellido" name="segundo_apellido" placeholder="Ej: Pérez" value="{{ $usuario->segundo_apellido }}">
        </div>
        <div class="col-md-6 mb-3">
            <label for="email" class="col-form-label">Correo:</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Ej: alguien@example.com" required value="{{ $usuario->email}}"></input>
            <div class="invalid-feedback">
                Por favor, ingresa un email válido.
                <small>Formato:
                    alguien@example.com
                </small>
            </div>
        </div>
    </div>
    <div class="row">

        <div class="col-md-6 mb-3">
            <label for="cumple_anios" class="col-form-label">Fecha de nacimiento:</label>
            <input type="date" class="form-control" id="cumple_anios" name="cumple_anios" required value="{{ $usuario->cumple_anios ? $usuario->cumple_anios->format('Y-m-d') : ''}}"></input>
            <div class="invalid-feedback">
                Elige la fecha de nacimiento.
            </div class="invalid-feedback">
        </div>
        <div class="col-md-6 mb-3">
            <label for="telefono" class="col-form-label">Teléfono:</label>
            <input type="tel" class="form-control" id="telefono" name="telefono" placeholder="Eje: 2223423245" value="{{ $usuario->telefono}}"></input>
        </div>
        <div class="col-md-6 mb-3">
            <label for="foto_perfil" class="col-form-label">Logo:</label>
            @if ($usuario->profile_photo_path)
                <img src="{{ asset('storage/' . $usuario->profile_photo_path) }}" alt="Foto de {{ $usuario->name }}" class="img-thumbnail img-fluid mt-2" style="max-width: 80px; max-height: 80px;">
                <label for="file" class="col-form-label">Cambiar:</label>
                <input type="file" class="form-control" id="foto_perfil" name="foto_perfil" accept="image/png, image/jpeg">
            @else
                <span class="badge badge-secondary">Sin foto</span>
                <br>
                <label for="file" class="col-form-label">Para subir un logo, selecciona un archivo.</label>
                <input type="file" class="form-control" id="foto_perfil" name="foto_perfil" accept="image/png, image/jpeg">
            @endif
            <div class="invalid-feedback">
                Por favor, selecciona una imagen válida.
                <small>Formatos permitidos: JPEG, PNG, GIF.</small>
                <small>Tamaño máximo: 5MB.</small>
                <small>Resolución mínima: 200x200px.</small>
                <small>Dimensiones máximas: 2000x2000px.</small>
                <small>Dimensiones recomendadas: 200x200px.</small>
                <small>Color de fondo: #ffffff.</small>
                <small>Color de texto: #000000.</small>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <label for="rol" class="col-form-label">Rol:</label>
            <select class="form-control" id="rol" name="rol" required>
                <option value="" disabled selected>Selecciona un rol</option>
                @foreach ($roles as $role)
                    @if ($role->name != 'Super Administrador')
                        <option value="{{ $role->id }}" {{ $usuario->hasRole($role->name) ? 'selected' : '' }}>{{ $role->name }}</option>
                    @endif
                @endforeach
            </select>
            <div class="invalid-feedback">
                Por favor, selecciona al menos un rol.
            </div>
        </div>
    </div>
</form>

