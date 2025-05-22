<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class OrdenReparacion extends Model
{
    use HasFactory;

    protected $table = 'ordenes_reparacion';

    protected $fillable = [
        'numero_orden',
        'cliente_id',
        'tecnico_id',
        'tipo_producto_id',
        'marca_producto_id',
        'modelo_producto',
        'acessorios',
        'descripcion_falla',
        'servicio_id',
        'fecha_ingreso',
        'fecha_entrega',
        'adelanto',
        'costo_reparacion',
        'estado_reparacion_id',
        'estado_venta_id',
        'usuario_id',
        'sucursal_id',
        'observaciones',
    ];

    protected $casts = [
        'fecha_ingreso' => 'date',
        'fecha_entrega' => 'date',
        'adelanto' => 'decimal:2',
        'costo_reparacion' => 'decimal:2',
    ];

    // Relaciones
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function tecnico()
    {
        return $this->belongsTo(User::class, 'tecnico_id');
    }

    public function tipoProducto()
    {
        return $this->belongsTo(TipoProducto::class);
    }

    public function marcaProducto()
    {
        return $this->belongsTo(Marca::class, 'marca_producto_id');
    }

    public function servicio()
    {
        return $this->belongsTo(Servicio::class);
    }

    public function estadoReparacion()
    {
        return $this->belongsTo(EstadoReparacion::class);
    }

    public function estadoVenta()
    {
        return $this->belongsTo(EstadosVenta::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }

    public static function getNextNumeroOrden()
    {
        $lastOrder = self::orderBy('numero_orden', 'desc')->first();

        if ($lastOrder) {
            return $lastOrder->numero_orden + 1;
        }

        return 1; // Si no hay órdenes, comienza desde 1
    }
}
