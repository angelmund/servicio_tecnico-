<?php
use Illuminate\Support\Facades\Route;


Route::get('/', [App\Http\Controllers\ServiciosController::class, 'index'])->name('Index');
Route::get('/create', [App\Http\Controllers\ServiciosController::class, 'create'])->name('Create');
Route::get('/edit/{servicio}', [App\Http\Controllers\ServiciosController::class, 'edit'])->name('Edit');
Route::post('/store/servicio', [App\Http\Controllers\ServiciosController::class,'store'])->name('Store');
Route::post('/update/servicio/{servicio}', [App\Http\Controllers\ServiciosController::class,'update'])->name('Update');
Route::post('/destroy/servicio/{id}', [App\Http\Controllers\ServiciosController::class,'activarDesactivarservicio'])->name('cambiarEstado');
