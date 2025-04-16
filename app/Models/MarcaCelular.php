<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarcaCelular extends Model
{
    protected $table = 'marcas_celulares';
    protected $fillable = [
        'nombre', 'descripcion', 'logo', 'activo',
        'created_at', 'updated_at',
    ];
    protected $casts = [
        'activo' => 'boolean',
    ];

}
