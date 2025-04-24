<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    protected $table = 'marcas';
    protected $fillable = [
        'nombre', 'descripcion', 'logo', 'activo',
        'created_at', 'updated_at',
    ];
    protected $casts = [
        'activo' => 'boolean',
    ];

}
