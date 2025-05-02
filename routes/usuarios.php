<?php
use Illuminate\Support\Facades\Route;


Route::get('/', [App\Http\Controllers\UsuariosController::class, 'index'])->name('Index');
Route::get('/create', [App\Http\Controllers\UsuariosController::class, 'create'])->name('Create');
Route::get('/edit/{usuario}', [App\Http\Controllers\UsuariosController::class, 'edit'])->name('Edit');
Route::post('/store/usuario', [App\Http\Controllers\UsuariosController::class,'store'])->name('Store');
Route::post('/update/usuario/{usuario}', [App\Http\Controllers\UsuariosController::class,'update'])->name('Update');
Route::post('/destroy/usuario/{id}', [App\Http\Controllers\UsuariosController::class,'activarDesactivarUser'])->name('cambiarEstado');
