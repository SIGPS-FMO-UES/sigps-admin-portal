<?php

namespace Database\Seeders;

use App\Models\Rol;
use Illuminate\Database\Seeder;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $roles = [
            'Administrador',
            'Coordinador UPS',
            'Coordinador de Carrera',
            'Docente Tutor',
            'Estudiante',
            'Auxiliar UPS',
        ];

        foreach ($roles as $nombre) {
            Rol::findOrCreate($nombre, 'web');
        }
    }
}
