<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    protected $table = 'sucursales';

    protected $fillable = [
        'nombre',
        'rfc',
        'razon_social',
        'pais',
        'estado_provincia',
        'ciudad',
        'colonia',
        'calle',
        'numero_exterior',
        'numero_interior',
        'codigo_postal',
        'telefono',
        'email',
        'encargado',
        'horarios',
        'activo',
        'regimen_fiscal'
    ];

    protected $casts = [
        'activo' => 'boolean',
        'horarios' => 'array',
    ];

    protected $attributes = [
        'pais' => 'México',
        'activo' => true,
        'horarios' => '{
            "lunes": {"apertura": "09:00", "cierre": "18:00"},
            "martes": {"apertura": "09:00", "cierre": "18:00"},
            "miercoles": {"apertura": "09:00", "cierre": "18:00"},
            "jueves": {"apertura": "09:00", "cierre": "18:00"},
            "viernes": {"apertura": "09:00", "cierre": "18:00"},
            "sabado": {"apertura": "09:00", "cierre": "17:00"},
            "domingo": {"apertura": null, "cierre": null}
        }'
    ];
}