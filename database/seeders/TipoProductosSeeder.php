<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoProductosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tiposProductos = [
            ['nombre' =>  'Mica cristal templado', 'descripcion' =>  'Mica cristal templada de alta calidad'],
            ['nombre' =>  'Funda', 'descripcion' =>  'Funda de alta calidad para smartphones'],
            ['nombre' =>  'Cargador', 'descripcion' =>  'Cargador de batería de alta calidad'],
            ['nombre' =>  'Cable USB', 'descripcion' =>  'Cable USB de alta calidad'],
            ['nombre' =>  'Audifonos', 'descripcion' =>  'Audifonos de alta calidad'],
            ['nombre' =>  'Bateria', 'descripcion' =>  'Batería de alta calidad'],
            ['nombre' =>  'Soporte', 'descripcion' =>  'Soporte de alta calidad'],
            ['nombre' =>  'Adaptador', 'descripcion' =>  'Adaptador de alta calidad'],
            ['nombre' =>  'Protector de pantalla', 'descripcion' =>  'Protector de pantalla de alta calidad'],
            ['nombre' =>  'Lente de camara', 'descripcion' =>  'Lente de camara de alta calidad'],
            ['nombre' =>  'Cargador de batería', 'descripcion' =>  'Cargador de batería de alta calidad'],
            ['nombre' =>  'Auriculares', 'descripcion' =>  'Auriculares de alta calidad'],
            ['nombre' =>  'Mouse', 'descripcion' =>  'Mouse de alta calidad'  ],
            ['nombre' =>  'Teclado', 'descripcion' =>  'Teclado de alta calidad'],
            ['nombre' =>  'Monitor', 'descripcion' =>  'Monitor de alta calidad'],
            ['nombre' =>  'Celular', 'descripcion' =>  'Celular de alta calidad'],
            ['nombre' =>  'Tablet', 'descripcion' =>  'Tablet de alta calidad'],
            ['nombre' =>  'Laptop', 'descripcion' =>  'Laptop de alta calidad'],
            ['nombre' =>  'Smartwatch', 'descripcion' =>  'Smartwatch de alta calidad'],
            ['nombre' =>  'Consola de videojuegos', 'descripcion' =>  'Consola de videojuegos de alta calidad'],
        ];

       
        foreach ($tiposProductos as $tiposProducto) {
            \App\Models\TipoProducto::create($tiposProducto);
        }
    }
}
