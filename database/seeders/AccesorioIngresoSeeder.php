<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccesorioIngresoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $accesorios = [
            ['nombre' => 'Funda', 'descripcion' => 'Accesorio para ajustar la pantalla de un celular'],
            ['nombre' => 'Cargador', 'descripcion' => 'Accesorio para cargar la batería de un celular'],
            ['nombre' => 'Cable USB', 'descripcion' => 'Accesorio para conectar el celular a una computadora'],
            ['nombre' => 'Audifonos', 'descripcion' => 'Accesorio para escuchar música'],
            ['nombre' => 'Batería', 'descripcion' => 'Accesorio para almacenar energía'],
            ['nombre' => 'Soporte para celular', 'descripcion' => 'Accesorio para sostener el celular'],
            ['nombre' => 'Adaptador de corriente', 'descripcion' => 'Accesorio para convertir corriente alterna en corriente continua'],
            ['nombre' => 'Adaptador de audio', 'descripcion' => 'Accesorio para convertir audio analógico en digital'],
            ['nombre' => 'Estuche rígido', 'descripcion' => 'Accesorio para proteger el celular'],
            ['nombre' => 'Funda de silicona', 'descripcion' => 'Accesorio para proteger el celular'],
            ['nombre' => 'Funda de cuero', 'descripcion' => 'Accesorio para proteger el celular'],
            ['nombre' => 'Funda de tela', 'descripcion' => 'Accesorio para proteger el celular'],
            ['nombre' => 'Funda de plástico', 'descripcion' => 'Accesorio para proteger el celular'],
            ['nombre' => 'Funda de metal', 'descripcion' => 'Accesorio para proteger el celular'],
            ['nombre' => 'Funda de vidrio templado', 'descripcion' => 'Accesorio para proteger la pantalla del celular'],
            ['nombre' => 'Chip', 'descripcion' =>'Accesorio para almacenar datos en el celular'],
            ['nombre' => 'Mica cristal templado', 'descripcion' => 'Accesorio para proteger la pantalla del celular'],
            ['nombre' => 'Mica de vidrio templado', 'descripcion' => 'Accesorio para proteger la pantalla del celular'],
        ];

        foreach ($accesorios as $accesorio) {
            \App\Models\AccesoriosIngreso::create($accesorio);
        }
    }
}
