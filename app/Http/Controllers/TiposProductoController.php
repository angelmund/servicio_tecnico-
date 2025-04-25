<?php

namespace App\Http\Controllers;

use App\Models\TipoProducto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
class TiposProductoController extends Controller
{
    public function index()
    {
        // Verificar si el usuario está autenticado
        if (Auth::check()) {
            $tipos_producto = TipoProducto::all();
            return view('administracion.tipo_producto.index', compact('tipos_producto'));
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
            return view('administracion.tipo_producto.create');
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
                        Rule::unique('tipo_productos')->ignore($request->id),
                    ],
                    'descripcion' => 'nullable|string', // Cambiado de 'text' a 'string'
                ],
                [
                    'nombre.required' => 'El nombre es obligatorio.',
                    'nombre.string' => 'El nombre debe ser una cadena de texto.',
                    'nombre.max' => 'El nombre no puede exceder los 255 caracteres.',
                    'nombre.unique' => 'Ya existe un tipo de producto con ese nombre.',
                    'descripcion.string' => 'La descripción debe ser una cadena de texto.'
                ]
            );

            // Si la validación falla, lanzar una excepción con los errores
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            DB::beginTransaction();

            $tipo_producto = new TipoProducto();
            $tipo_producto->nombre = $request->input('nombre');
            $tipo_producto->descripcion = $request->input('descripcion');


            $tipo_producto->activo = true;
            $tipo_producto->save();
            DB::commit();

            return response()->json([
                'message' => 'Tipo de producto guardado con éxito',
                'tipo_producto' => $tipo_producto,
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
                'message' => 'Error al crear el tipo de producto',
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
            $tipo_producto = TipoProducto::findOrFail($id);
            return view('administracion.tipo_producto.edit', compact('tipo_producto'));
        }
        return redirect()->route('login')->withErrors(['auth' => 'Debe iniciar sesión para realizar esta acción.']);
    }

    protected function guardarEdicion(Request $request, TipoProducto $tipo_producto)
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
                        Rule::unique('tipo_productos')->ignore($tipo_producto->id),
                    ],
                    'descripcion' => 'nullable|string'
                ],
                [
                    'nombre.required' => 'El nombre del tipo de producto es obligatorio.',
                    'nombre.string' => 'El nombre del tipo de producto debe ser una cadena de texto.',
                    'nombre.max' => 'El nombre del tipo de producto no puede exceder los 255 caracteres.',
                    'nombre.unique' => 'Ya existe un tipo de producto con ese nombre.',
                    'descripcion.string' => 'La descripción debe ser una cadena de texto.'
                ]
            );

            // Si la validación falla, lanzar una excepción con los errores
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            DB::beginTransaction();

            $tipo_producto->nombre = $request->input('nombre');
            $tipo_producto->descripcion = $request->input('descripcion');

            $tipo_producto->activo = true;

            $tipo_producto->save();
            DB::commit();

            return response()->json([
                'message' => 'Tipo de producto actualizado con éxito',
                'tipo_producto' => $tipo_producto,
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
                'message' => 'Error al actualizar el tipo de producto',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $tipo_producto)
    {
        // Verificar si el usuario está autenticado
        if (Auth::check()) {
            $tipo_producto = TipoProducto::findOrFail($tipo_producto);
            // Si el usuario está autenticado, llama a la lógica para guardar la edición
            return $this->guardarEdicion($request, $tipo_producto);
        }

        // Si el usuario no está autenticado, redirige o devuelve un error
        return redirect()->route('login')->withErrors([
            'auth' => 'Debe iniciar sesión para realizar esta acción.',
        ]);
    }
    protected function activar(TipoProducto $tipo_producto)
    {
        try {
            DB::beginTransaction();
            $tipo_producto->activo = true;
            $tipo_producto->save();
            DB::commit();
            return [
                'success' => true,
                'message' => 'Tipo de producto activado con éxito',
                'Noti' => 1
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'success' => false,
                'message' => 'Error al activar el tipo de producto',
                'error' => $e->getMessage()
            ];
        }
    }

    protected function desactivar(TipoProducto $tipo_producto)
    {
        try {
            DB::beginTransaction();
            $tipo_producto->activo = false;
            $tipo_producto->save();
            DB::commit();
            return [
                'success' => true,
                'message' => 'Tipo de producto desactivado con éxito',
                'Noti' => 1
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'success' => false,
                'message' => 'Error al desactivar el tipo de producto',
                'error' => $e->getMessage()
            ];
        }
    }

    public function activarDesactivartipoProducto(Request $request, $id)
    {
        if (Auth::check()) {
            $tipo_producto = TipoProducto::findOrFail($id);
            $accion = $request->input('action');

            if ($accion === 'desactivar' && $tipo_producto->activo) {
                $result = $this->desactivar($tipo_producto);
            } elseif ($accion === 'activar' && !$tipo_producto->activo) {
                $result = $this->activar($tipo_producto);
            } else {
                return response()->json([
                    'message' => 'Acción no válida o no necesaria',
                    'Noti' => 0
                ], 400);
            }

            if ($result['success']) {
                $tipo_producto->refresh(); // Recargar el modelo para obtener los datos actualizados
                return response()->json([
                    'message' => $result['message'],
                    'Noti' => $result['Noti'],
                    'tipo_producto' => $tipo_producto,
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
