<?php
use Illuminate\Support\Facades\Route;


Route::get('/', [App\Http\Controllers\EstadosVentaController::class, 'index'])->name('Index');
Route::get('/create', [App\Http\Controllers\EstadosVentaController::class, 'create'])->name('Create');
Route::get('/edit/{id}', [App\Http\Controllers\EstadosVentaController::class, 'edit'])->name('Edit');
Route::post('/store/estadosVenta', [App\Http\Controllers\EstadosVentaController::class,'store'])->name('Store');
Route::post('/update/estadosVenta/{estado_venta}', [App\Http\Controllers\EstadosVentaController::class, 'update'])->name('Update');
Route::post('/estado/estadosVenta/{id}', [App\Http\Controllers\EstadosVentaController::class,'activarDesactivarEstadoVenta'])->name('cambiarEstado');
