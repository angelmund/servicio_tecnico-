<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EstadosVentaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $estados = [
            ['nombre' => 'Pendiente', 'descripcion' => 'Venta en espera de aprobación'],
            ['nombre' => 'En Espera', 'descripcion' => 'Venta en espera de pago o confirmación'],
            ['nombre' => 'En Proceso', 'descripcion' => 'La venta está siendo procesada'],
            ['nombre' => 'Entregado', 'descripcion' => 'La venta ha sido entregada al cliente'],
            ['nombre' => 'Finalizado', 'descripcion' => 'La venta ha sido completada y cerrada'],
            ['nombre' => 'Cancelado', 'descripcion' => 'La venta ha sido cancelada por el cliente'],
            ['nombre' => 'Reembolsado', 'descripcion' => 'La venta ha sido reembolsada al cliente'],
            ['nombre' => 'En Revisión', 'descripcion' => 'La venta está bajo revisión por el equipo de ventas'],
            ['nombre' => 'En Espera de Envío', 'descripcion' => 'La venta está lista para ser enviada al cliente'],
            ['nombre' => 'En Proceso de Devolución', 'descripcion' => 'La venta está en proceso de devolución por parte del cliente'],
        ];

        foreach ($estados as $estado) {
            \App\Models\EstadosVenta::create($estado);
        }
    }
}
