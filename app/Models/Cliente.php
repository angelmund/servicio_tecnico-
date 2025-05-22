<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'primer_apellido',
        'segundo_apellido',
        'telefono',
        'email',
    ];

    /**
     * Get the full name of the client.
     *
     * @return string
     */
    public function getNombreCompleto()
    {
        return "{$this->nombre} {$this->primer_apellido} {$this->segundo_apellido}";
    }

    /**
     * Get the orders for the client.
     */
    public function ordenesReparacion()
    {
        return $this->hasMany(OrdenReparacion::class);
    }
}
