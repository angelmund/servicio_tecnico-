<?php
use Illuminate\Support\Facades\Route;


Route::get('/', [App\Http\Controllers\EstadosReparacionController::class, 'index'])->name('Index');
Route::get('/create', [App\Http\Controllers\EstadosReparacionController::class, 'create'])->name('Create');
Route::get('/edit/{id}', [App\Http\Controllers\EstadosReparacionController::class, 'edit'])->name('Edit');
Route::post('/store/estadosReparacion', [App\Http\Controllers\EstadosReparacionController::class,'store'])->name('Store');
Route::post('/update/estadosReparacion/{estado_reparacion}', [App\Http\Controllers\EstadosReparacionController::class, 'update'])->name('Update');
Route::post('/estado/estadosReparacion/{id}', [App\Http\Controllers\EstadosReparacionController::class,'activarDesactivarEstadoreparacion'])->name('cambiarEstado');
