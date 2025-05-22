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
        Schema::create('sucursales', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('rfc', 13)->unique();
            $table->string('razon_social');   
            $table->string('pais')->default('México');
            $table->string('estado_provincia');
            $table->string('ciudad');
            $table->string('colonia');
            $table->string('calle');
            $table->string('numero_exterior');
            $table->string('numero_interior')->nullable();
            $table->string('codigo_postal');
            $table->string('telefono');
            $table->string('email')->nullable();
            $table->unsignedBigInteger('encargado_id')->nullable();
            $table->json('horarios')->nullable()->comment('Horarios de apertura y cierre para cada día de la semana')->default(json_encode([
                'lunes' => ['apertura' => '09:00', 'cierre' => '18:00'],
                'martes' => ['apertura' => '09:00', 'cierre' => '18:00'],
                'miercoles' => ['apertura' => '09:00', 'cierre' => '18:00'],
                'jueves' => ['apertura' => '09:00', 'cierre' => '18:00'],
                'viernes' => ['apertura' => '09:00', 'cierre' => '18:00'],
                'sabado' => ['apertura' => '09:00', 'cierre' => '17:00'],
                'domingo' => ['apertura' => null, 'cierre' => null],
            ]));
            $table->boolean('activo')->default(true);
            $table->text('regimen_fiscal')->nullable(); 
            $table->timestamps();

            $table->foreign('encargado_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sucursales');
    }
};
