<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Membresia extends Model
{
    protected $table ='membresias';
    protected $fillable = ['user_id','tipo_membresia_id' ,'fecha_inicio', 'fecha_inicio', 'monto_pagado', 'fecha_ultimo_pago', 'activo'];
    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'fecha_ultimo_pago' => 'date',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function tipoMembresia()
    {
        return $this->belongsTo(TipoMembresia::class);
    }
}
