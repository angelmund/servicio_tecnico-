<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoProducto extends Model
{
    protected $table = 'tipo_productos';
    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];
}
