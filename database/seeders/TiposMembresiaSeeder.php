<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TiposMembresiaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tiposMembresias = [
            ['nombre' => 'Prueba', 'duracion_dias' => 15, 'precio' => 0000],
            ['nombre' => 'Mensual', 'duracion_dias' => 30, 'precio' => 1000],
            ['nombre' => 'Anual', 'duracion_dias' => 12, 'precio' => 12000],
        ];

        foreach ($tiposMembresias as $tipoMembresia) {
            \App\Models\TipoMembresia::create($tipoMembresia);
        }
    }
}
