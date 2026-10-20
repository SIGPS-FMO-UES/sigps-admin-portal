<?php

namespace Database\Seeders;

use App\Models\Permiso;
use Illuminate\Database\Seeder;

class PermisoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permisos = [
            'gestionar_usuarios',
            'gestionar_roles',
            'crear_proyectos',
            'aprobar_proyectos',
            'asignar_tutor',
            'inscribir_alumnos',
            'subir_documentos',
            'revisar_documentos',
            'finalizar_proyectos',
            'ver_reportes',
        ];

        foreach ($permisos as $nombre) {
            Permiso::firstOrCreate(['nombre_permiso' => $nombre]);
        }
    }
}
