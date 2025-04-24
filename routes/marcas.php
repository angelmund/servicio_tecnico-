<?php
use Illuminate\Support\Facades\Route;


Route::get('/', [App\Http\Controllers\MarcasController::class, 'index'])->name('Index');
// Route::get('/api_v1_marcas-celulares', [App\Http\Controllers\MarcasController::class, 'api'])->name('apiMarcasCelulares');
Route::get('/create', [App\Http\Controllers\MarcasController::class, 'create'])->name('Create');
Route::get('/edit/{marca}', [App\Http\Controllers\MarcasController::class, 'edit'])->name('Edit');
Route::post('/store/marca', [App\Http\Controllers\MarcasController::class,'store'])->name('Store');
Route::post('/update/marca/{marca}', [App\Http\Controllers\MarcasController::class,'update'])->name('Update');
Route::post('/destroy/marca/{id}', [App\Http\Controllers\MarcasController::class,'activarDesactivarMarca'])->name('cambiarEstado');
