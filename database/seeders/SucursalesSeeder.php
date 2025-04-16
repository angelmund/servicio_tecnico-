<?php

namespace Database\Seeders;

use App\Models\Sucursal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
class SucursalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('es_MX');

        for ($i = 0; $i < 5; $i++) {
            Sucursal::create([
                'nombre' => $faker->company,
                'rfc' => $faker->regexify('[A-Z]{4}[0-9]{6}[A-Z0-9]{3}'),
                'razon_social' => $faker->company . ' ' . $faker->companySuffix,
                'pais' => 'México',
                'estado_provincia' => $faker->state,
                'ciudad' => $faker->city,
                'colonia' => $faker->cityPrefix,
                'calle' => $faker->streetName,
                'numero_exterior' => $faker->buildingNumber,
                'numero_interior' => $faker->optional(0.3)->secondaryAddress,
                'codigo_postal' => $faker->postcode,
                'telefono' => $faker->phoneNumber,
                'email' => $faker->companyEmail,
                'encargado' => $faker->name,
                'horarios' => json_encode([
                    'lunes' => ['apertura' => '09:00', 'cierre' => '18:00'],
                    'martes' => ['apertura' => '09:00', 'cierre' => '18:00'],
                    'miercoles' => ['apertura' => '09:00', 'cierre' => '18:00'],
                    'jueves' => ['apertura' => '09:00', 'cierre' => '18:00'],
                    'viernes' => ['apertura' => '09:00', 'cierre' => '18:00'],
                    'sabado' => ['apertura' => '09:00', 'cierre' => '14:00'],
                    'domingo' => ['apertura' => null, 'cierre' => null],
                ]),
                'activo' => true,
                'regimen_fiscal' => $faker->randomElement(['Persona Física', 'Persona Moral']),
            ]);
        }
    }
}
