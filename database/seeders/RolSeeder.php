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
        $roles = [
            'Administrador',
            'Coordinador UPS',
            'Coordinador de Carrera',
            'Docente Tutor',
            'Estudiante',
        ];

        foreach ($roles as $nombre) {
            Rol::firstOrCreate(['nombre_rol' => $nombre]);
        }
    }
}
