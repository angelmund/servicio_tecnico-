<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class ServiciosController extends Controller
{
    public function index()
    {
        // Verificar si el usuario está autenticado
        if (Auth::check()) {
            $servicios = Servicio::all();
            return view('administracion.servicios.index', compact('servicios'));
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
            return view('administracion.servicios.create');
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
                    'nombre' => [
                        'required',
                        'string',
                        'max:255',
                        Rule::unique('servicios')->ignore($request->id),
                    ],
                    'descripcion' => 'nullable|string', // Cambiado de 'text' a 'string'
                    'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                ],
                [
                    'nombre.required' => 'El nombre del Servicio es obligatorio.',
                    'nombre.string' => 'El nombre del Servicio debe ser una cadena de texto.',
                    'nombre.max' => 'El nombre del Servicio no puede exceder los 255 caracteres.',
                    'nombre.unique' => 'Ya existe un Servicio con ese nombre.',
                    'descripcion.string' => 'La descripción debe ser una cadena de texto.',
                    'precio.numeric' => 'El precio debe ser un número.',
                    'logo.image' => 'El logo debe ser un archivo de logo.',
                    'logo.mimes' => 'El logo debe ser de tipo jpeg, png o jpg.',
                    'logo.max' => 'El logo no puede exceder los 2MB.',
                ]
            );

            // Si la validación falla, lanzar una excepción con los errores
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            DB::beginTransaction();

            $Servicio = new Servicio();
            $Servicio->nombre = $request->input('nombre');
            $Servicio->descripcion = $request->input('descripcion');
            $Servicio->precio = $request->input('precio');

            if ($request->hasFile('logo')) {
                $logo = $request->file('logo');
                $logoName = time() . '.' . $logo->getClientOriginalExtension();

                // Guardar la logo en el almacenamiento
                $path = Storage::disk('public')->putFileAs('servicios', $logo, $logoName);

                // Guardar la ruta relativa en la base de datos
                $Servicio->logo = $path;
            }

            $Servicio->activo = true;
            $Servicio->save();
            DB::commit();

            return response()->json([
                'message' => 'Servicio guardado con éxito',
                'Servicio' => $Servicio,
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
                'message' => 'Error al crear el servicio',
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
            $Servicio = Servicio::findOrFail($id);
            return view('administracion.servicios.edit', compact('Servicio'));
        }
        return redirect()->route('login')->withErrors(['auth' => 'Debe iniciar sesión para realizar esta acción.']);
    }

    protected function guardarEdicion(Request $request, Servicio $Servicio)
    {
        try {
            // Validar con regla de validación
            $validator = Validator::make(
                $request->all(),
                [
                    'nombre' => [
                        'required',
                        'string',
                        'max:255',
                        Rule::unique('Servicios')->ignore($Servicio->id),
                    ],
                    'descripcion' => 'nullable|string',
                    'precio' => 'nullable|numeric',
                    'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                ],
                [
                    'nombre.required' => 'El nombre del Servicio es obligatorio.',
                    'nombre.string' => 'El nombre del Servicio debe ser una cadena de texto.',
                    'nombre.max' => 'El nombre del Servicio no puede exceder los 255 caracteres.',
                    'nombre.unique' => 'Ya existe un Servicio con ese nombre.',
                    'descripcion.string' => 'La descripción debe ser una cadena de texto.',
                    'precio.numeric' => 'El precio debe ser un número.',
                    'logo.image' => 'El logo debe ser un archivo de logo.',
                    'logo.mimes' => 'El logo debe ser de tipo jpeg, png o jpg.',
                    'logo.max' => 'El logo no puede exceder los 2MB.',
                ]
            );

            // Si la validación falla, lanzar una excepción con los errores
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            DB::beginTransaction();

            $Servicio->nombre = $request->input('nombre');
            $Servicio->descripcion = $request->input('descripcion');
            $Servicio->precio = $request->input('precio');

            // Manejar la logo si se proporciona
            if ($request->hasFile('logo')) {
                // Eliminar la logo anterior si existe
                if ($Servicio->logo) {
                    Storage::disk('public')->delete($Servicio->logo);
                }

                $logo = $request->file('logo');
                $logoName = time() . '.' . $logo->getClientOriginalExtension();

                // Guardar la nueva logo en el almacenamiento
                $path = Storage::disk('public')->putFileAs('servicios', $logo, $logoName);

                // Guardar la ruta relativa en la base de datos
                $Servicio->logo = $path;
            }

            $Servicio->activo = true;

            $Servicio->save();
            DB::commit();

            return response()->json([
                'message' => 'Servicio actualizado con éxito',
                'Servicio' => $Servicio,
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
                'message' => 'Error al actualizar el Servicio',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $Servicio)
    {
        // Verificar si el usuario está autenticado
        if (Auth::check()) {
            $Servicio = Servicio::findOrFail($Servicio);
            // Si el usuario está autenticado, llama a la lógica para guardar la edición
            return $this->guardarEdicion($request, $Servicio);
        }

        // Si el usuario no está autenticado, redirige o devuelve un error
        return redirect()->route('login')->withErrors([
            'auth' => 'Debe iniciar sesión para realizar esta acción.',
        ]);
    }
    protected function activar(Servicio $Servicio)
    {
        try {
            DB::beginTransaction();
            $Servicio->activo = true;
            $Servicio->save();
            DB::commit();
            return [
                'success' => true,
                'message' => 'Servicio activado con éxito',
                'Noti' => 1
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'success' => false,
                'message' => 'Error al activar el Servicio',
                'error' => $e->getMessage()
            ];
        }
    }

    protected function desactivar(Servicio $Servicio)
    {
        try {
            DB::beginTransaction();
            $Servicio->activo = false;
            $Servicio->save();
            DB::commit();
            return [
                'success' => true,
                'message' => 'Servicio desactivado con éxito',
                'Noti' => 1
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'success' => false,
                'message' => 'Error al desactivar el Servicio',
                'error' => $e->getMessage()
            ];
        }
    }

    public function activarDesactivarServicio(Request $request, $id)
    {
        if (Auth::check()) {
            $Servicio = Servicio::findOrFail($id);
            $accion = $request->input('action');

            if ($accion === 'desactivar' && $Servicio->activo) {
                $result = $this->desactivar($Servicio);
            } elseif ($accion === 'activar' && !$Servicio->activo) {
                $result = $this->activar($Servicio);
            } else {
                return response()->json([
                    'message' => 'Acción no válida o no necesaria',
                    'Noti' => 0
                ], 400);
            }

            if ($result['success']) {
                $Servicio->refresh(); // Recargar el modelo para obtener los datos actualizados
                return response()->json([
                    'message' => $result['message'],
                    'Noti' => $result['Noti'],
                    'Servicio' => $Servicio,
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
