<?php

namespace App\Http\Controllers;

use App\Models\EstadoReparacion;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class EstadosReparacionController extends Controller
{
    public function index()
    {
        // Verificar si el usuario está autenticado
        if (Auth::check()) {
            $estados_reparacion = EstadoReparacion::all();
            return view('administracion.estados_reparacion.index', compact('estados_reparacion'));
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
            return view('administracion.estados_reparacion.create');
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
                        Rule::unique('estados_reparacion')->ignore($request->id),
                    ],
                    'descripcion' => 'nullable|string', // Cambiado de 'text' a 'string'
                ],
                [
                    'nombre.required' => 'El nombre es obligatorio.',
                    'nombre.string' => 'El nombre debe ser una cadena de texto.',
                    'nombre.max' => 'El nombre no puede exceder los 255 caracteres.',
                    'nombre.unique' => 'Ya existe un estado de reparación con ese nombre.',
                    'descripcion.string' => 'La descripción debe ser una cadena de texto.'
                ]
            );

            // Si la validación falla, lanzar una excepción con los errores
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            DB::beginTransaction();

            $estados_reparacion = new EstadoReparacion();
            $estados_reparacion->nombre = $request->input('nombre');
            $estados_reparacion->descripcion = $request->input('descripcion');


            $estados_reparacion->activo = true;
            $estados_reparacion->save();
            DB::commit();

            return response()->json([
                'message' => 'Estado de reparación guardado con éxito',
                'estados_reparacion' => $estados_reparacion,
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
                'message' => 'Error al crear el estado de reparación',
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
            $estado_reparacion = EstadoReparacion::findOrFail($id);
            return view('administracion.estados_reparacion.edit', compact('estado_reparacion'));
        }
        return redirect()->route('login')->withErrors(['auth' => 'Debe iniciar sesión para realizar esta acción.']);
    }

    protected function guardarEdicion(Request $request, EstadoReparacion $estado_reparacion)
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
                        Rule::unique('estados_reparacion')->ignore($estado_reparacion->id),
                    ],
                    'descripcion' => 'nullable|string'
                ],
                [
                    'nombre.required' => 'El nombre de la marca es obligatorio.',
                    'nombre.string' => 'El nombre de la marca debe ser una cadena de texto.',
                    'nombre.max' => 'El nombre de la marca no puede exceder los 255 caracteres.',
                    'nombre.unique' => 'Ya existe una marca con ese nombre.',
                    'descripcion.string' => 'La descripción debe ser una cadena de texto.'
                ]
            );

            // Si la validación falla, lanzar una excepción con los errores
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            DB::beginTransaction();

            $estado_reparacion->nombre = $request->input('nombre');
            $estado_reparacion->descripcion = $request->input('descripcion');

            $estado_reparacion->activo = true;

            $estado_reparacion->save();
            DB::commit();

            return response()->json([
                'message' => 'Estado de reparación actualizado con éxito',
                'estado_reparacion' => $estado_reparacion,
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

    public function update(Request $request, $estado_reparacion)
    {
        // Verificar si el usuario está autenticado
        if (Auth::check()) {
            $estado_reparacion = EstadoReparacion::findOrFail($estado_reparacion);
            // Si el usuario está autenticado, llama a la lógica para guardar la edición
            return $this->guardarEdicion($request, $estado_reparacion);
        }

        // Si el usuario no está autenticado, redirige o devuelve un error
        return redirect()->route('login')->withErrors([
            'auth' => 'Debe iniciar sesión para realizar esta acción.',
        ]);
    }
    protected function activar(EstadoReparacion $estado_reparacion)
    {
        try {
            DB::beginTransaction();
            $estado_reparacion->activo = true;
            $estado_reparacion->save();
            DB::commit();
            return [
                'success' => true,
                'message' => 'Estado de reparación activado con éxito',
                'Noti' => 1
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'success' => false,
                'message' => 'Error al activar el estado de reparación',
                'error' => $e->getMessage()
            ];
        }
    }

    protected function desactivar(EstadoReparacion $estado_reparacion)
    {
        try {
            DB::beginTransaction();
            $estado_reparacion->activo = false;
            $estado_reparacion->save();
            DB::commit();
            return [
                'success' => true,
                'message' => 'Estado de reparación desactivado con éxito',
                'Noti' => 1
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'success' => false,
                'message' => 'Error al desactivar el estado de reparación',
                'error' => $e->getMessage()
            ];
        }
    }

    public function activarDesactivarEstadoreparacion(Request $request, $id)
    {
        if (Auth::check()) {
            $estado_reparacion = EstadoReparacion::findOrFail($id);
            $accion = $request->input('action');

            if ($accion === 'desactivar' && $estado_reparacion->activo) {
                $result = $this->desactivar($estado_reparacion);
            } elseif ($accion === 'activar' && !$estado_reparacion->activo) {
                $result = $this->activar($estado_reparacion);
            } else {
                return response()->json([
                    'message' => 'Acción no válida o no necesaria',
                    'Noti' => 0
                ], 400);
            }

            if ($result['success']) {
                $estado_reparacion->refresh(); // Recargar el modelo para obtener los datos actualizados
                return response()->json([
                    'message' => $result['message'],
                    'Noti' => $result['Noti'],
                    'estado_reparacion' => $estado_reparacion,
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
