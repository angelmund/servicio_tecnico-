<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstadosVenta extends Model
{
    protected $table = 'estados_venta';
    protected $fillable = [
        'nombre',
        'descripcion',
        'estado',
    ];
    protected $casts = [
        'estado' => 'boolean',
    ];
}
