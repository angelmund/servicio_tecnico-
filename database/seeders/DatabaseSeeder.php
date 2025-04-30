<?php

namespace Database\Seeders;

use App\Models\AccesoriosIngreso;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Administrador',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345678'),

        ]);

        // $this->call(AccesorioIngresoSeeder::class);
        $this->call(EstadosReparacionSeeder::class);
        $this->call(EstadosVentaSeeder::class);
        $this->call(MarcasCelularesSeeder::class);
        $this->call(ServiciosSeeder::class);
        $this->call(SucursalesSeeder::class);
        $this->call(TipoProductosSeeder::class);
        $this->call(TiposMembresiaSeeder::class);
    }
}
