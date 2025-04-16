<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoMembresia extends Model
{
    protected $table = 'tipos_membresia';
    protected $fillable = ['nombre', 'duracion_dias', 'precio'];
    protected $casts = ['duracion_dias' => 'integer', 'precio' => 'float'];

    public function membresias()
    {
        return $this->hasMany(Membresia::class, 'tipo_membresia_id');
    }
}
