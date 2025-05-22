<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ordenes_reparacion', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('numero_orden')->unique();
            $table->unsignedBigInteger('cliente_id');
            $table->unsignedBigInteger('tecnico_id');
            $table->unsignedBigInteger('tipo_producto_id'); // Tipo de producto
            $table->unsignedBigInteger('marca_producto_id'); // Marca del producto
            $table->string('modelo_producto'); // Modelo del equipo o dispositivo  a reparar
            $table->text('acessorios'); // Accesorios que trae el producto
            $table->text('descripcion_falla'); // Descripción de la falla
            $table->unsignedBigInteger('servicio_id');
            $table->date('fecha_ingreso'); // Fecha de ingreso del producto
            $table->date('fecha_entrega'); // Fecha de salida del producto 
            $table->decimal('adelanto',2)->nullable(); // Costo total de la reparación
            $table->decimal('costo_reparacion',2); // Costo total de la reparación
            $table->unsignedBigInteger('estado_reparacion_id'); // Estado de la reparación
            $table->unsignedBigInteger('estado_venta_id'); // Estado de pago
            $table->unsignedBigInteger('usuario_id'); // Usuario que crea la orden de reparación
            $table->unsignedBigInteger('sucursal_id'); // Sucursal donde se crea la orden de reparación
            $table->string('observaciones')->nullable(); // Observaciones adicionales
            
            $table->timestamps();

            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->foreign('tecnico_id')->references('id')->on('users');
            $table->foreign('tipo_producto_id')->references('id')->on('tipo_productos');
            $table->foreign('marca_producto_id')->references('id')->on('marcas');
            $table->foreign('servicio_id')->references('id')->on('servicios');
            $table->foreign('estado_reparacion_id')->references('id')->on('estados_reparacion');
            $table->foreign('estado_venta_id')->references('id')->on('estados_venta');
            $table->foreign('usuario_id')->references('id')->on('users');
            $table->foreign('sucursal_id')->references('id')->on('sucursales');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordenes_reparacion');
    }
};
