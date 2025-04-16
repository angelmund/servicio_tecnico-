<?php
use Illuminate\Support\Facades\Route;


Route::get('/', [App\Http\Controllers\MarcasCelularesController::class, 'index'])->name('Index');
Route::get('/api_v1_marcas-celulares', [App\Http\Controllers\MarcasCelularesController::class, 'api'])->name('apiMarcasCelulares');
Route::get('/create', [App\Http\Controllers\MarcasCelularesController::class, 'create'])->name('Create');
Route::get('/edit/{marca}', [App\Http\Controllers\MarcasCelularesController::class, 'edit'])->name('Edit');
Route::post('/store/marcaCelular', [App\Http\Controllers\MarcasCelularesController::class,'store'])->name('Store');
Route::post('/update/marcaCelular/{marca}', [App\Http\Controllers\MarcasCelularesController::class,'update'])->name('Update');
Route::post('/destroy/marcaCelular/{marca}', [App\Http\Controllers\MarcasCelularesController::class,'destroy'])->name('Delete');
