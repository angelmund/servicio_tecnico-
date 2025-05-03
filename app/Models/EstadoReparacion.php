<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstadoReparacion extends Model
{
    protected $table = 'estados_reparacion';
    protected $fillable = [
        'id',
        'nombre',
        'descripcion',
        // 'color',
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
