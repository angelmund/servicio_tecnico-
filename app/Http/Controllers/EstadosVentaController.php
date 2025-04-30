<?php

namespace App\Http\Controllers;

use App\Models\EstadosVenta;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class EstadosVentaController extends Controller
{
    public function index()
    {
        // Verificar si el usuario está autenticado
        if (Auth::check()) {
            $estados_venta = EstadosVenta::all();
            return view('administracion.estados_venta.index', compact('estados_venta'));
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
            return view('administracion.estados_venta.create');
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
                        Rule::unique('estados_venta')->ignore($request->id),
                    ],
                    'descripcion' => 'nullable|string', // Cambiado de 'text' a 'string'
                ],
                [
                    'nombre.required' => 'El nombre es obligatorio.',
                    'nombre.string' => 'El nombre debe ser una cadena de texto.',
                    'nombre.max' => 'El nombre no puede exceder los 255 caracteres.',
                    'nombre.unique' => 'Ya existe un nombre para ese estado de estado_venta.',
                    'descripcion.string' => 'La descripción debe ser una cadena de texto.'
                ]
            );

            // Si la validación falla, lanzar una excepción con los errores
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            DB::beginTransaction();

            $estados_venta = new EstadosVenta();
            $estados_venta->nombre = $request->input('nombre');
            $estados_venta->descripcion = $request->input('descripcion');


            $estados_venta->activo = true;
            $estados_venta->save();
            DB::commit();

            return response()->json([
                'message' => 'Estado de venta guardado con éxito',
                'estados_venta' => $estados_venta,
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
                'message' => 'Error al crear el estado de venta',
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
            $estado_venta = EstadosVenta::findOrFail($id);
            return view('administracion.estados_venta.edit', compact('estado_venta'));
        }
        return redirect()->route('login')->withErrors(['auth' => 'Debe iniciar sesión para realizar esta acción.']);
    }

    protected function guardarEdicion(Request $request, EstadosVenta $estado_venta)
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
                        Rule::unique('estados_venta')->ignore($estado_venta->id),
                    ],
                    'descripcion' => 'nullable|string'
                ],
                [
                    'nombre.required' => 'El nombre es obligatorio.',
                    'nombre.string' => 'El nombre debe ser una cadena de texto.',
                    'nombre.max' => 'El nombre no puede exceder los 255 caracteres.',
                    'nombre.unique' => 'Ya existe un nombre para ese estado de estado_venta.',
                    'descripcion.string' => 'La descripción debe ser una cadena de texto.'
                ]
            );

            // Si la validación falla, lanzar una excepción con los errores
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            DB::beginTransaction();

            $estado_venta->nombre = $request->input('nombre');
            $estado_venta->descripcion = $request->input('descripcion');

            $estado_venta->activo = true;

            $estado_venta->save();
            DB::commit();

            return response()->json([
                'message' => 'Estado de venta actualizado con éxito',
                'estado_venta' => $estado_venta,
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
                'message' => 'Error al actualizar el estado de venta',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $estado_venta)
    {
        // Verificar si el usuario está autenticado
        if (Auth::check()) {
            $estado_venta = EstadosVenta::findOrFail($estado_venta);
            // Si el usuario está autenticado, llama a la lógica para guardar la edición
            return $this->guardarEdicion($request, $estado_venta);
        }

        // Si el usuario no está autenticado, redirige o devuelve un error
        return redirect()->route('login')->withErrors([
            'auth' => 'Debe iniciar sesión para realizar esta acción.',
        ]);
    }
    protected function activar(EstadosVenta $estado_venta)
    {
        try {
            DB::beginTransaction();
            $estado_venta->activo = true;
            $estado_venta->save();
            DB::commit();
            return [
                'success' => true,
                'message' => 'Estado de venta activado con éxito',
                'Noti' => 1
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'success' => false,
                'message' => 'Error al activar el estado de venta',
                'error' => $e->getMessage()
            ];
        }
    }

    protected function desactivar(EstadosVenta $estado_venta)
    {
        try {
            DB::beginTransaction();
            $estado_venta->activo = false;
            $estado_venta->save();
            DB::commit();
            return [
                'success' => true,
                'message' => 'Estado de venta desactivado con éxito',
                'Noti' => 1
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'success' => false,
                'message' => 'Error al desactivar el estado de venta',
                'error' => $e->getMessage()
            ];
        }
    }

    public function activarDesactivarEstadoVenta(Request $request, $id)
    {
        if (Auth::check()) {
            $estado_venta = EstadosVenta::findOrFail($id);
            $accion = $request->input('action');

            if ($accion === 'desactivar' && $estado_venta->activo) {
                $result = $this->desactivar($estado_venta);
            } elseif ($accion === 'activar' && !$estado_venta->activo) {
                $result = $this->activar($estado_venta);
            } else {
                return response()->json([
                    'message' => 'Acción no válida o no necesaria',
                    'Noti' => 0
                ], 400);
            }

            if ($result['success']) {
                $estado_venta->refresh(); // Recargar el modelo para obtener los datos actualizados
                return response()->json([
                    'message' => $result['message'],
                    'Noti' => $result['Noti'],
                    'estado_venta' => $estado_venta,
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
