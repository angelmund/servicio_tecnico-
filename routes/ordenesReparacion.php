<?php
use Illuminate\Support\Facades\Route;


Route::get('/', [App\Http\Controllers\OrdenesReparacionController::class, 'index'])->name('Index');
Route::get('/create', [App\Http\Controllers\OrdenesReparacionController::class, 'create'])->name('Create');
Route::get('/edit/{id}', [App\Http\Controllers\OrdenesReparacionController::class, 'edit'])->name('Edit');
Route::post('/store/ordenesReparacion', [App\Http\Controllers\OrdenesReparacionController::class,'store'])->name('Store');
Route::post('/update/ordenesReparacion/{ordenReparacion}', [App\Http\Controllers\OrdenesReparacionController::class, 'update'])->name('Update');
// Route::post('/estado/ordenesReparacion/{id}', [App\Http\Controllers\OrdenesReparacionController::class,'activarDesactivarEstadoVenta'])->name('cambiarEstado');
