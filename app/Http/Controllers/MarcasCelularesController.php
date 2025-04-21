<?php

namespace App\Http\Controllers;

use App\Models\MarcaCelular;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class MarcasCelularesController extends Controller
{
    // public function index(Request $request)
    // {
    //     if ($request->ajax()) {
    //         $marcas = MarcaCelular::query();
    //         return DataTables::of($marcas)
    //             ->addColumn('action', function ($marca) {
    //                 $actionBtn = '<div class="btn-group dropdown">';
    //                 $actionBtn .= '<button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">Acciones</button>';
    //                 $actionBtn .= '<ul class="dropdown-menu" role="menu">';
    //                 $actionBtn .= '<li><a class="dropdown-item btn btn-success btn-crear" data-bs-toggle="modal" data-bs-target="#crear" data-form-url="' . route('MarcasCelularesCreate') . '"><i class="fas fa-plus"></i> Crear</a></li>';
    //                 $actionBtn .= '<li><a class="dropdown-item btn btn-warning btn-editar" data-bs-toggle="modal" data-bs-target="#editar" data-id="' . $marca->id . '" data-form-url="' . route('MarcasCelularesEdit', [$marca->id, '']) . '"><i class="fas fa-edit"></i> Editar</a></li>';
    //                 $actionBtn .= '<li><a class="dropdown-item btn btn-danger btn-eliminar" data-bs-toggle="modal" data-bs-target="#eliminar" data-id="' . $marca->id . '" data-delete-url="' . route('MarcasCelularesDelete', [$marca->id, '']) . '"><i class="fas fa-trash-alt"></i> Eliminar</a></li>';
    //                 $actionBtn .= '</ul></div>';
    //                 return $actionBtn;
    //             })
    //             ->rawColumns(['action'])
    //             ->make(true);
    //     }
    //     return view('administracion.marcas_celulares.index');
    // }

    public function index()
    {
        // Verificar si el usuario está autenticado
        if (Auth::check()) {
            $marcas = MarcaCelular::all();
            return view('administracion.marcas_celulares.index', compact('marcas'));
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
            return view('administracion.marcas_celulares.create');
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
                        Rule::unique('marcas_celulares')->ignore($request->id),
                    ],
                    'descripcion' => 'nullable|string', // Cambiado de 'text' a 'string'
                    'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Aumentado el tamaño máximo a 2MB
                ],
                [
                    'nombre.required' => 'El nombre es obligatorio.',
                    'nombre.string' => 'El nombre debe ser una cadena de texto.',
                    'nombre.max' => 'El nombre no puede exceder los 255 caracteres.',
                    'nombre.unique' => 'Ya existe una marca con ese nombre.',
                    'descripcion.string' => 'La descripción debe ser una cadena de texto.',
                    'logo.image' => 'El archivo debe ser una imagen.',
                    'logo.mimes' => 'La imagen debe ser de tipo jpeg, png o jpg.',
                    'logo.max' => 'La imagen no puede exceder los 2MB.',
                ]
            );

            // Si la validación falla, lanzar una excepción con los errores
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            DB::beginTransaction();

            $marca = new MarcaCelular();
            $marca->nombre = $request->input('nombre');
            $marca->descripcion = $request->input('descripcion');

            if ($request->hasFile('logo')) {
                $logo = $request->file('logo');
                $logoName = time() . '.' . $logo->getClientOriginalExtension();

                // Guardar la imagen en el almacenamiento
                $path = Storage::disk('public')->putFileAs('marcas_celulares', $logo, $logoName);

                // Guardar la ruta relativa en la base de datos
                $marca->logo = $path;
            }
            $marca->activo = true;
            // dd($marca);
            $marca->save();
            DB::commit();

            return response()->json([
                'message' => 'Marca guardada con éxito',
                'marca' => $marca,
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
                'message' => 'Error al crear la marca de celular',
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


    public function edit(MarcaCelular $marca)
    {
        // Verificar si el usuario está autenticado
        if (Auth::check()) {
            // Si el usuario está autenticado, devuelve la vista para editar la marca
            $marca = MarcaCelular::findOrFail($marca->id);
            if (!$marca) {
                return redirect()->route('marcasCelulares.index')->with('error', 'Marca no encontrada');
            }
            return view('administracion.marcas_celulares.edit', compact('marca'));
        }

        // Si el usuario no está autenticado, redirige o devuelve un error
        return redirect()->route('login')->withErrors([
            'auth' => 'Debe iniciar sesión para realizar esta acción.',
        ]);
    }

    protected function guardarEdicion(Request $request, MarcaCelular $marca)
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
                        Rule::unique('marcas_celulares')->ignore($marca->id),
                    ],
                    'descripcion' => 'nullable|string',
                    'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Aumentado el tamaño máximo a 2MB
                ],
                [
                    'nombre.required' => 'El nombre de la marca es obligatorio.',
                    'nombre.string' => 'El nombre de la marca debe ser una cadena de texto.',
                    'nombre.max' => 'El nombre de la marca no puede exceder los 255 caracteres.',
                    'nombre.unique' => 'Ya existe una marca con ese nombre.',
                    'descripcion.string' => 'La descripción debe ser una cadena de texto.',
                    'logo.image' => 'El archivo debe ser una imagen.',
                    'logo.mimes' => 'La imagen debe ser de tipo jpeg, png o jpg.',
                    'logo.max' => 'La imagen no puede exceder los 2MB.',
                ]
            );

            // Si la validación falla, lanzar una excepción con los errores
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            DB::beginTransaction();

            $marca->nombre = $request->input('nombre');
            $marca->descripcion = $request->input('descripcion');

            if ($request->hasFile('logo')) {
                // Eliminar la imagen anterior si existe
                if ($marca->logo) {
                    Storage::disk('public')->delete($marca->logo);
                }

                $logo = $request->file('logo');
                $logoName = time() . '.' . $logo->getClientOriginalExtension();

                // Guardar la nueva imagen en el almacenamiento
                $path = Storage::disk('public')->putFileAs('marcas_celulares', $logo, $logoName);

                // Guardar la ruta relativa en la base de datos
                $marca->logo = $path;
            }
            $marca->activo = true;
            // dd($marca);
            $marca->save();
            DB::commit();

            return response()->json([
                'message' => 'Marca actualizada
                con éxito',
                'marca' => $marca,
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
                'message' => 'Error al actualizar la marca de celular',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, MarcaCelular $marca)
    {
        // Verificar si el usuario está autenticado
        if (Auth::check()) {
            // Si el usuario está autenticado, llama a la lógica para guardar la edición
            return $this->guardarEdicion($request, $marca);
        }

        // Si el usuario no está autenticado, redirige o devuelve un error
        return redirect()->route('login')->withErrors([
            'auth' => 'Debe iniciar sesión para realizar esta acción.',
        ]);
    }
    protected function activar(MarcaCelular $marca)
    {
        try {
            DB::beginTransaction();
            $marca->activo = true;
            $marca->save();
            DB::commit();
            return [
                'success' => true,
                'message' => 'Marca activada con éxito',
                'Noti' => 1
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'success' => false,
                'message' => 'Error al activar la marca de celular',
                'error' => $e->getMessage()
            ];
        }
    }

    protected function desactivar(MarcaCelular $marca)
    {
        try {
            DB::beginTransaction();
            $marca->activo = false;
            $marca->save();
            DB::commit();
            return [
                'success' => true,
                'message' => 'Marca desactivada con éxito',
                'Noti' => 1
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'success' => false,
                'message' => 'Error al desactivar la marca de celular',
                'error' => $e->getMessage()
            ];
        }
    }

    public function activarDesactivarMarca(Request $request, $id)
    {
        if (Auth::check()) {
            $marca = MarcaCelular::findOrFail($id);
            $accion = $request->input('action');

            if ($accion === 'desactivar' && $marca->activo) {
                $result = $this->desactivar($marca);
            } elseif ($accion === 'activar' && !$marca->activo) {
                $result = $this->activar($marca);
            } else {
                return response()->json([
                    'message' => 'Acción no válida o no necesaria',
                    'Noti' => 0
                ], 400);
            }

            if ($result['success']) {
                $marca->refresh(); // Recargar el modelo para obtener los datos actualizados
                return response()->json([
                    'message' => $result['message'],
                    'Noti' => $result['Noti'],
                    'marca' => $marca,
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
