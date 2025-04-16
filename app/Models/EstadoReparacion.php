<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstadoReparacion extends Model
{
    protected $table = 'estados_reparacion';
    protected $fillable = [
        'nombre',
        'descripcion',
        'created_at',
        'updated_at',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'activo' => 'bool',
    ];
}
