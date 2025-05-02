<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class RolesPermisosSeeder extends Seeder
{
    public function run(): void
    {
        // Wrap everything in a transaction
        DB::transaction(function () {
            // Crear roles
            $roles = [
                ['id' => 1, 'name' => 'Super Administrador', 'guard_name' => 'web', 'descripcion' => 'Administrador del sistema'],
                ['id' => 2, 'name' => 'Administrador', 'guard_name' => 'web', 'descripcion' => 'Administrador del sistema'],
                ['id' => 3, 'name' => 'Técnico', 'guard_name' => 'web', 'descripcion' => 'Técnico en reparación de celulares'],
                ['id' => 4, 'name' => 'Vendedor', 'guard_name' => 'web', 'descripcion' => 'Vendedor en la sucursal'],
                ['id' => 5, 'name' => 'Gerente', 'guard_name' => 'web', 'descripcion' => 'Gerente de la sucursal'],
            ];
            
            foreach ($roles as $role) {
                Role::create($role);
            }

            // Crear permisos 
            $permissions = [
                'crear', 'editar', 'eliminar', 'ver', 'vender', 'administracion', 'superadministrador'
            ];

            foreach ($permissions as $permission) {
                Permission::create(['name' => $permission]);
            }

            // Asignar permisos a roles
            $superAdmin = Role::findByName('Super Administrador');
            $superAdmin->givePermissionTo(Permission::all());

            $admin = Role::findByName('Administrador');
            $admin->givePermissionTo(['crear', 'editar', 'eliminar', 'ver', 'vender', 'administracion']);

            $tecnico = Role::findByName('Técnico');
            $tecnico->givePermissionTo(['ver', 'editar']);

            $Vendedor = Role::findByName('Vendedor');
            $Vendedor->givePermissionTo(['crear', 'ver', 'vender']);

            $gerente = Role::findByName('Gerente');
            $gerente->givePermissionTo(['crear', 'editar', 'eliminar', 'ver', 'vender']);

            // Crear superadmin
            $user = User::factory()->create([
                'name' => 'Administrador',
                'primer_apellido' => 'Admin',
                'segundo_apellido' => 'G',
                'telefono' => '1234567891',
                'cumple_anios' => '1999-10-01',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('12345678'),
            ]);
            // Asignar rol al superadmin a la cuenta creada
            $user->assignRole('Super Administrador');

            // Crear usuario administrador
            $userAdmin = User::factory()->create([
                'name' => 'Administrador',
                'primer_apellido' => 'St',
                'segundo_apellido' => 'G',
                'telefono' => '123456789',
                'cumple_anios' => '2000-01-01',
                'email' => 'adminst@gmail.com',
                'password' => bcrypt('12345678'),
            ]);

            // Asignar rol al administrador a la cuenta creada
            $userAdmin->assignRole('Administrador');
            // Crear usuario Vendedor
            $userVendedor = User::factory()->create([
                'name' => 'Vendedor',
                'primer_apellido' => 'Vela',
                'segundo_apellido' => 'H',
                'telefono' => '354354354',
                'cumple_anios' => '2001-09-09',
                'email' => 'Vendedor@gmail.com',
                'password' => bcrypt('12345678'),
            ]); 
            // Asignar rol a la Vendedor a la cuenta creada
            $userVendedor->assignRole('Vendedor');
            // Crear usuario tecnico
            $userTecnico = User::factory()->create([
                'name' => 'Tecnico',
                'primer_apellido' => 'Sandrón',
                'segundo_apellido' => 'Guerrero',
                'telefono' => '34543253',
                'cumple_anios' => '1999-03-06',
                'email' => 'tecnico@gmail.com',
                'password' => bcrypt('12345678'),
            ]);
            // Asignar rol al tecnico a la cuenta creada
            $userTecnico->assignRole('Técnico');
            // Crear usuario gerente
            $userGerente = User::factory()->create([
                'name' => 'Gerente',
                'primer_apellido' => 'González',
                'segundo_apellido' => 'Y',
                'telefono' => '553454334',
                'cumple_anios' => '2000-12-12',
                'email' => 'gerente@gmail.com',
                'password' => bcrypt('12345678'),
            ]);
            // Asignar rol al gerente a la cuenta creada
            $userGerente->assignRole('Gerente');

        });
    }
}
