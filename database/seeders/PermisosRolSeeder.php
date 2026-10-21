<?php

namespace Database\Seeders;

use App\Models\Permiso;
use App\Models\Rol;
use Illuminate\Database\Seeder;

class PermisosRolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Rol::where('name', 'Administrador')->first();
        $coordUps = Rol::where('name', 'Coordinador UPS')->first();
        $coordCarrera = Rol::where('name', 'Coordinador de Carrera')->first();
        $tutor = Rol::where('name', 'Docente Tutor')->first();
        $estudiante = Rol::where('name', 'Estudiante')->first();

        // 1. Administrador: todos los permisos
        if ($admin) {
            $admin->syncPermissions(Permiso::all());
        }

        // 2. Coordinador UPS
        if ($coordUps) {
            $coordUps->syncPermissions([
                'crear_proyectos',
                'aprobar_proyectos',
                'asignar_tutor',
                'inscribir_alumnos',
                'subir_documentos',
                'revisar_documentos',
                'finalizar_proyectos',
                'ver_reportes',
            ]);
        }

        // 3. Coordinador de Carrera
        if ($coordCarrera) {
            $coordCarrera->syncPermissions([
                'crear_proyectos',
                'asignar_tutor',
                'inscribir_alumnos',
                'revisar_documentos',
                'ver_reportes',
            ]);
        }

        // 4. Docente Tutor
        if ($tutor) {
            $tutor->syncPermissions([
                'subir_documentos',
                'revisar_documentos',
                'ver_reportes',
            ]);
        }

        // 5. Estudiante
        if ($estudiante) {
            $estudiante->syncPermissions([
                'subir_documentos',
            ]);
        }
    }
}
