<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use App\Models\OrdenReparacion;
use App\Models\Servicio;
use App\Models\TipoProducto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;


class OrdenesReparacionController extends Controller
{
    public function index()
    {
        // Verificar si el usuario está autenticado
        if (Auth::check()) {
            $ordenes_reparacion = OrdenReparacion::all();
            return view('ordenes_reparacion.index', compact('ordenes_reparacion'));
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
            $nextNumeroOrden = OrdenReparacion::getNextNumeroOrden();
            $marcas = Marca::all();
            $tipos_productos = TipoProducto::all();
            $servicios = Servicio::all();
            return view('ordenes_reparacion.create', compact('nextNumeroOrden', 'marcas', 'tipos_productos', 'servicios'));
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
                        Rule::unique('ordenes_reparacion')->ignore($request->id),
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

            $tipo_producto = new OrdenReparacion();
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
}
