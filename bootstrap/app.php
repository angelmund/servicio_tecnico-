<?php


use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware(['web', 'auth'])
                ->prefix('marcas') // el nombre en la ruta por ejemplo /modalidades/crear
                ->name('Marcas') // el nombre de la ruta por ejemplo ModalidadesCrear
                ->group(base_path('routes/marcas.php'));
            // Añadimos la ruta para los estados de reparación
            Route::middleware(['web', 'auth'])
                ->prefix('estadosReparacion') 
                ->name('estadosReparacion') 
                ->group(base_path('routes/estadosReparacion.php'));
            // Añadimos la ruta para los tipos de productos
            Route::middleware(['web', 'auth'])
                ->prefix('tiposProductos') 
                ->name('tiposProductos') 
                ->group(base_path('routes/tiposProductos.php'));
            // Añadimos la ruta para los tipos de servicios
            Route::middleware(['web', 'auth'])
                ->prefix('Servicios') 
                ->name('Servicios') 
                ->group(base_path('routes/servicios.php'));
            // Añadimos la ruta para los estados de venta
            Route::middleware(['web', 'auth'])
                ->prefix('estadosVenta') 
                ->name('estadosVenta') 
                ->group(base_path('routes/estadosVenta.php'));
            // Añadimos la ruta para los usuarios
            Route::middleware(['web', 'auth'])
                ->prefix('usuarios') 
                ->name('usuarios') 
                ->group(base_path('routes/usuarios.php'));
            // Añadimos la ruta para altas de servicios
            Route::middleware(['web', 'auth'])
                ->prefix('ordenesReparacion') 
                ->name('ordenesReparacion') 
                ->group(base_path('routes/ordenesReparacion.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
