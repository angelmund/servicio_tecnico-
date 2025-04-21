<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MarcasCelularesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $marcas = [
            ['nombre' => 'Apple', 'descripcion' => 'Fabricante de smartphones'],
            ['nombre' => 'Samsung', 'descripcion' => 'Fabricante de smartphones'],
            ['nombre' => 'Motorola', 'descripcion' => 'Fabricante de smartphones'],
            ['nombre' => 'Nokia', 'descripcion' => 'Fabricante de smartphones'],
            ['nombre' => 'Sony', 'descripcion' => 'Fabricante de smartphones'],
            ['nombre' => 'LG', 'descripcion' => 'Fabricante de smartphones'],
            ['nombre' => 'HTC', 'descripcion' => 'Fabricante de smartphones'],
            ['nombre' => 'OnePlus', 'descripcion' => 'Fabricante de smartphones'],
            ['nombre' => 'Google', 'descripcion' => 'Fabricante de smartphones'],
            ['nombre' => 'Realme', 'descripcion' => 'Fabricante de smartphones'],
            ['nombre' => 'Vivo', 'descripcion' => 'Fabricante de smartphones'],
            ['nombre' => 'Lenovo', 'descripcion' => 'Fabricante de smartphones'],
            ['nombre' => 'Asus', 'descripcion' => 'Fabricante de smartphones'],
            ['nombre' => 'ZTE', 'descripcion' => 'Fabricante de smartphones'],
            ['nombre' => 'Alcatel', 'descripcion' => 'Fabricante de smartphones'],
            ['nombre' => 'TCL', 'descripcion' => 'Fabricante de smartphones'],
            ['nombre' => 'Honor', 'descripcion' => 'Fabricante de smartphones'],
            ['nombre' => 'BlackBerry', 'descripcion' => 'Fabricante de smartphones'],
            ['nombre' => 'Panasonic', 'descripcion' => 'Fabricante de smartphones'],
            ['nombre' => 'Micromax', 'descripcion' => 'Fabricante de smartphones'],
            ['nombre' => 'Tecno', 'descripcion' => 'Fabricante de smartphones'],
            ['nombre' => 'Infinix', 'descripcion' => 'Fabricante de smartphones'],
            ['nombre' => 'Xiaomi', 'descripcion' => 'Fabricante de smartphones'],
            ['nombre' => 'Huawei', 'descripcion' => 'Fabricante de smartphones'],
            ['nombre' => 'Oppo', 'descripcion' => 'Fabricante de smartphones'],
        ];

        foreach ($marcas as $marca) {
            \App\Models\MarcaCelular::create($marca);
        }
    }
}
