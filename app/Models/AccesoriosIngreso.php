<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccesoriosIngreso extends Model
{
    protected $table = 'accesorios_ingreso';
    protected $fillable = [
        'nombre',
        'descripcion',
        'activo',
        'created_at',
        'updated_at',
    ];
    protected $casts = [
        'activo' => 'boolean',
    ];

}
