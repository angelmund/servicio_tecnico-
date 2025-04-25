<?php
use Illuminate\Support\Facades\Route;


Route::get('/', [App\Http\Controllers\TiposProductoController::class, 'index'])->name('Index');
Route::get('/create', [App\Http\Controllers\TiposProductoController::class, 'create'])->name('Create');
Route::get('/edit/{tipoProducto}', [App\Http\Controllers\TiposProductoController::class, 'edit'])->name('Edit');
Route::post('/store/tipoProducto', [App\Http\Controllers\TiposProductoController::class,'store'])->name('Store');
Route::post('/update/tipoProducto/{tipoProducto}', [App\Http\Controllers\TiposProductoController::class,'update'])->name('Update');
Route::post('/destroy/tipoProducto/{id}', [App\Http\Controllers\TiposProductoController::class,'activarDesactivartipoProducto'])->name('cambiarEstado');
