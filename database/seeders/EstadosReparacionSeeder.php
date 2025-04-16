<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EstadosReparacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $estados = [
            ['nombre' => 'Pendiente', 'descripcion' => 'Reparación en espera de aprobación'],
            ['nombre' => 'En Espera', 'descripcion' => 'Reparación en espera de piezas o insumos'],
            ['nombre' => 'En Proceso', 'descripcion' => 'Reparación en curso'],
            ['nombre' => 'Finalizado', 'descripcion' => 'Reparación completada y lista para entrega'],
            ['nombre' => 'Cancelado', 'descripcion' => 'Reparación cancelada por el cliente o por falta de piezas'],
        ];

        foreach ($estados as $estado) {
            \App\Models\EstadoReparacion::create($estado);
        }
    }
}
