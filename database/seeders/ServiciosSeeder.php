<?php

namespace Database\Seeders;

use App\Models\Servicio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiciosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $servicios = [
            [
                'nombre' => 'Revisión general',
                'descripcion' => 'Revisión completa del dispositivo y detectar la falla.',
                'precio' => 50.00,
            ],
            [
                'nombre' => 'Instalación de software',
                'descripcion' => 'Instalar el software necesario para el funcionamiento del dispositivo.',
                'precio' => 100.00,
            ],
            [
                'nombre' => 'Mantenimiento preventivo',
                'descripcion' => 'Realizar mantenimientos preventivos en el dispositivo para garantizar su funcionamiento.',
                'precio' => 30.00,
            ],
            [
                'nombre' => 'Reparación de hardware',
                'descripcion' => 'Reparar el hardware del dispositivo para corregir cualquier falla o problema.',
                'precio' => 200.00,
            ],
            [
                'nombre' => 'Soporte técnico',
                'descripcion' => 'Atención y solución de problemas técnicos en el dispositivo.',
                'precio' => 75.00,
            ]
        ];

        foreach ($servicios as $servicio) {
            Servicio::create($servicio);
        }
    }
}
