<?php

namespace App\Http\Controllers;

use App\Models\EstadosVenta;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UsuariosController extends Controller
{
    public function index()
    {
        // Verificar si el usuario está autenticado
        if (Auth::check()) {
            $usuarios = User::all();
            return view('administracion.usuarios.index', compact('usuarios'));
        }
        // Si el usuario no está autenticado, redirige o devuelve un error
        return redirect()->route('login')->withErrors([
            'auth' => 'Debe iniciar sesión para realizar esta acción.',
        ]);
    }

    public function create()
    {
        // Verificar si el usuario está autenticado
        if (Auth::check()) {
            $roles = DB::table('roles')->get();
            return view('administracion.usuarios.create', compact('roles'));
        }
        // Si el usuario no está autenticado, redirige o devuelve un error
        return redirect()->route('login')->withErrors([
            'auth' => 'Debe iniciar sesión para realizar esta acción.',
        ]);
    }

    protected function guardarInfo(Request $request)
    {
        // dd($request->all());
        try {
            // Validar con regla de validación
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => [
                        'required',
                        'string',
                        'max:255'
                    ],
                    'email' => [
                        'required',
                        'email',
                        'max:255',
                        Rule::unique('users')->where(function ($query) {
                            return $query->where('activo', true);
                        }),

                    ],
                    'profile_photo_path' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                    'primer_apellido' => 'string|max:255',
                    'segundo_apellido' => 'nullable|string|max:255',
                    'telefono' => 'nullable|string|max:15',
                    'cumple_anios' => 'date',
                ],
                [
                    'name.required' => 'El nombre es obligatorio.',
                    'name.string' => 'El nombre debe ser una cadena de texto.',
                    'name.max' => 'El nombre no puede exceder los 255 caracteres.',
                    'name.unique' => 'Ya existe un nombre de usuario con ese nombre.',
                    'email.unique' => 'Ya existe un correo electrónico registrado.',
                    'email.required' => 'El correo electrónico es obligatorio.',
                    'email.email' => 'El correo electrónico debe ser una dirección de correo válida.',
                    'email.max' => 'El correo electrónico no puede exceder los 255 caracteres.',
                    'profile_photo_path.image' => 'La imagen de perfil debe ser una imagen.',
                    'profile_photo_path.mimes' => 'La imagen de perfil debe tener un formato válido (JPEG, PNG o JPG).',
                    'profile_photo_path.max' => 'La imagen de perfil no puede pesar más de 2MB.',
                    'primer_apellido.string' => 'El primer apellido debe ser una cadena de texto.',
                    'primer_apellido.max' => 'El primer apellido no puede exceder los 255 caracteres.',
                    'telefono.nullable' => 'El teléfono es opcional.',
                    'telefono.string' => 'El teléfono debe ser una cadena de texto.',
                    'telefono.max' => 'El teléfono no puede exceder los 15 caracteres.',
                    'cumple_anios.required' => 'La fecha de cumpleaños es obligatoria.',
                    'cumple_anios.date' => 'La fecha de cumpleaños debe ser una fecha válida.',
                ]
            );

            // Si la validación falla, lanzar una excepción con los errores
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            DB::beginTransaction();

            $usuario = new User();
            $usuario->name = $request->input('name');
            $usuario->primer_apellido = $request->input('primer_apellido');
            $usuario->segundo_apellido = $request->input('segundo_apellido');
            $usuario->telefono = $request->input('telefono');
            $usuario->cumple_anios = $request->input('cumple_anios');
            $usuario->email = $request->input('email');
            $password_temporal = 'psw2%$.190';
            $usuario->password = bcrypt($password_temporal);
            $usuario->activo = true;
            // guardar la imagen de perfil si se proporciona
            if ($request->hasFile('foto_perfil')) {
                $foto_perfil = $request->file('foto_perfil');
                $foto_perfilName = time() . '.' . $foto_perfil->getClientOriginalExtension();
                Storage::disk('public')->put('usuarios/' . $foto_perfilName, file_get_contents($foto_perfil));
                $usuario->profile_photo_path = 'usuarios/' . $foto_perfilName;
            }

            $usuario->save();

            //asignar rol que venga en el request
            if ($request->has('rol')) {
                $rolId = $request->input('rol');
                $rol = Role::findById($rolId);
                if ($rol) {
                    $usuario->assignRole($rol);
                } else {
                    throw new \Exception("No se encontró el rol con ID: " . $rolId);
                }
            }
            // Obtener el nombre del rol asignado
            $rolNombre = $usuario->roles->first() ? $usuario->roles->first()->name : null;
            DB::commit();

            return response()->json([
                'message' => 'Usuario guardado con éxito',
                'usuario' => [
                    'id' => $usuario->id,
                    'name' => $usuario->name,
                    'email' => $usuario->email,
                    'primer_apellido' => $usuario->primer_apellido,
                    'segundo_apellido' => $usuario->segundo_apellido,
                    'telefono' => $usuario->telefono,
                    'cumple_anios' => $usuario->cumple_anios,
                    'profile_photo_url' => $usuario->profile_photo_url,
                    'rol' => $rolNombre
                ],
                'Noti' => 1 //Manejar el tipo de notificación 1 cuando se crea un registro
            ], 200);
            $usuario->save();

            //

            DB::commit();

            return response()->json([
                'message' => 'Usuario guardado con éxito',
                'usuario' => $usuario,
                'Noti' => 1 //Manejar el tipo de notificación 1 cuando se crea un registro
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Error al crear el usuario',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        // Verificar si el usuario está autenticado
        if (Auth::check()) {
            // Si el usuario está autenticado, llama a la lógica para guardar la información
            return $this->guardarInfo($request);
        }

        // Si el usuario no está autenticado, redirige o devuelve un error
        return redirect()->route('login')->withErrors([
            'auth' => 'Debe iniciar sesión para realizar esta acción.',
        ]);
    }

    public function edit($id)
    {
        if (Auth::check()) {
            $usuario = User::findOrFail($id);
            $roles = DB::table('roles')->get();
            return view('administracion.usuarios.edit', compact('usuario', 'roles'));
        }
        return redirect()->route('login')->withErrors(['auth' => 'Debe iniciar sesión para realizar esta acción.']);
    }

    protected function guardarEdicion(Request $request, User $usuario)
    {
        try {
            // Validar con regla de validación
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => [
                        'required',
                        'string',
                        'max:255',
                        Rule::unique('users')->ignore($usuario->id),
                    ],
                    'email' => [
                        'required',
                        'email',
                        'max:255',
                        Rule::unique('users')->ignore($usuario->id)->where(function ($query) {
                            return $query->where('activo', true);
                        }),
                    ],
                    'profile_photo_path' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                    'primer_apellido' => 'string|max:255',
                    'segundo_apellido' => 'nullable|string|max:255',
                    'telefono' => 'nullable|string|max:15',
                    'cumple_anios' => 'date',
                ],
                [
                    'name.required' => 'El nombre es obligatorio.',
                    'name.string' => 'El nombre debe ser una cadena de texto.',
                    'name.max' => 'El nombre no puede exceder los 255 caracteres.',
                    'name.unique' => 'Ya existe un nombre de usuario con ese nombre.',
                    'email.unique' => 'Ya existe un correo electrónico registrado.',
                    'email.required' => 'El correo electrónico es obligatorio.',
                    'email.email' => 'El correo electrónico debe ser una dirección de correo válida.',
                    'email.max' => 'El correo electrónico no puede exceder los 255 caracteres.',
                    'profile_photo_path.image' => 'La imagen de perfil debe ser una imagen.',
                    'profile_photo_path.mimes' => 'La imagen de perfil debe tener un formato válido (JPEG, PNG o JPG).',
                    'profile_photo_path.max' => 'La imagen de perfil no puede pesar más de 2MB.',
                    'primer_apellido.string' => 'El primer apellido debe ser una cadena de texto.',
                    'primer_apellido.max' => 'El primer apellido no puede exceder los 255 caracteres.',
                    'telefono.nullable' => 'El teléfono es opcional.',
                    'telefono.string' => 'El teléfono debe ser una cadena de texto.',
                    'telefono.max' => 'El teléfono no puede exceder los 15 caracteres.',
                    'cumple_anios.required' => 'La fecha de cumpleaños es obligatoria.',
                    'cumple_anios.date' => 'La fecha de cumpleaños debe ser una fecha válida.',
                ]
            );

            // Si la validación falla, lanzar una excepción con los errores
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            DB::beginTransaction();

            $usuario->name = $request->input('name');
            $usuario->primer_apellido = $request->input('primer_apellido');
            $usuario->segundo_apellido = $request->input('segundo_apellido');
            $usuario->telefono = $request->input('telefono');
            $usuario->cumple_anios = $request->input('cumple_anios');
            $usuario->email = $request->input('email');

            // Actualizar la contraseña solo si se proporciona
            if ($request->input('password')) {
                $usuario->password = bcrypt($request->input('password'));
            }
            // guardar la imagen de perfil si se proporciona
            if ($request->hasFile('foto_perfil')) {
                // Eliminar la imagen anterior si existe
                if ($usuario->profile_photo_path) {
                    Storage::disk('public')->delete($usuario->profile_photo_path);
                }
                $foto_perfil = $request->file('foto_perfil');
                $foto_perfilName = time() . '.' . $foto_perfil->getClientOriginalExtension();
                Storage::disk('public')->put('usuarios/' . $foto_perfilName, file_get_contents($foto_perfil));
                $usuario->profile_photo_path = 'usuarios/' . $foto_perfilName;
            }
            // Si no se proporciona un nuevo rol, mantener el rol actual
            if (!$request->has('rol')) {
                $usuario->syncRoles($usuario->roles);
            }

            // Con este nuevo bloque:
            if ($request->has('rol')) {
                $rolId = $request->input('rol');
                $rol = Role::findById($rolId);
                if ($rol) {
                    $usuario->syncRoles([$rol]); // Esto eliminará todos los roles anteriores y asignará solo el nuevo rol
                } else {
                    throw new \Exception("No se encontró el rol con ID: " . $rolId);
                }
            } else {
                // Si no se proporciona un nuevo rol, eliminar todos los roles
                $usuario->syncRoles([]);
            }
            // Obtener el nombre del rol asignado
            $rolNombre = $usuario->roles->first() ? $usuario->roles->first()->name : null;
            $usuario->activo = true;

            $usuario->save();
            DB::commit();

            return response()->json([
                'message' => 'Estado de reparación actualizado con éxito',
                'usuario' => [
                    'id' => $usuario->id,
                    'name' => $usuario->name,
                    'email' => $usuario->email,
                    'primer_apellido' => $usuario->primer_apellido,
                    'segundo_apellido' => $usuario->segundo_apellido,
                    'telefono' => $usuario->telefono,
                    'cumple_anios' => $usuario->cumple_anios,
                    'profile_photo_path' => $usuario->profile_photo_path,
                    'activo' => $usuario->activo,
                    'rol' => $rolNombre
                ],
                'Noti' => 2 // Manejar el tipo de notificación 2 cuando se edita un registro
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Error al actualizar el estado de reparación',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $usuario)
    {
        // Verificar si el usuario está autenticado
        if (Auth::check()) {
            $usuario = User::findOrFail($usuario);
            // Si el usuario está autenticado, llama a la lógica para guardar la edición
            return $this->guardarEdicion($request, $usuario);
        }

        // Si el usuario no está autenticado, redirige o devuelve un error
        return redirect()->route('login')->withErrors([
            'auth' => 'Debe iniciar sesión para realizar esta acción.',
        ]);
    }
    protected function activar(User $usuario)
    {
        try {
            DB::beginTransaction();
            $usuario->activo = true;
            $usuario->save();
            DB::commit();
            return [
                'success' => true,
                'message' => 'Usuario activado con éxito',
                'Noti' => 1
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'success' => false,
                'message' => 'Error al activar al usuario',
                'error' => $e->getMessage()
            ];
        }
    }

    protected function desactivar(User $usuario)
    {
        try {
            DB::beginTransaction();
            $usuario->activo = false;
            $usuario->save();
            DB::commit();
            return [
                'success' => true,
                'message' => 'Usuario desactivado con éxito',
                'Noti' => 1
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'success' => false,
                'message' => 'Error al desactivar al usuario',
                'error' => $e->getMessage()
            ];
        }
    }

    public function activarDesactivarUser(Request $request, $id)
    {
        if (Auth::check()) {
            $usuario = User::findOrFail($id);
            $accion = $request->input('action');

            if ($accion === 'desactivar' && $usuario->activo) {
                $result = $this->desactivar($usuario);
            } elseif ($accion === 'activar' && !$usuario->activo) {
                $result = $this->activar($usuario);
            } else {
                return response()->json([
                    'message' => 'Acción no válida o no necesaria',
                    'Noti' => 0
                ], 400);
            }

            if ($result['success']) {
                $usuario->refresh(); // Recargar el modelo para obtener los datos actualizados
                return response()->json([
                    'message' => $result['message'],
                    'Noti' => $result['Noti'],
                    'usuario' => $usuario,
                ]);
            } else {
                return response()->json([
                    'message' => $result['message'],
                    'error' => $result['error'],
                    'Noti' => 0
                ], 500);
            }
        }

        return response()->json([
            'message' => 'Debe iniciar sesión para realizar esta acción.',
            'Noti' => 0
        ], 401);
    }
}
