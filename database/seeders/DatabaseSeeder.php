<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolSeeder::class,
            PermisoSeeder::class,
            PermisosRolSeeder::class,
            UsuarioSeeder::class,
            RolesUsuarioSeeder::class,
            DocumentoSeeder::class,
            ProyectoSeeder::class,
        ]);
    }
}
