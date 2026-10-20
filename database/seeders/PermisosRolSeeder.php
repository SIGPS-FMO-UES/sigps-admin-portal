<?php

namespace Database\Seeders;

use App\Models\Permiso;
use App\Models\PermisosRol;
use App\Models\Rol;
use Illuminate\Database\Seeder;

class PermisosRolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Rol::where('nombre_rol', 'Administrador')->first();
        $coordUps = Rol::where('nombre_rol', 'Coordinador UPS')->first();
        $coordCarrera = Rol::where('nombre_rol', 'Coordinador de Carrera')->first();
        $tutor = Rol::where('nombre_rol', 'Docente Tutor')->first();
        $estudiante = Rol::where('nombre_rol', 'Estudiante')->first();

        $todosPermisos = Permiso::all();

        // 1. Administrador: todos los permisos
        if ($admin) {
            foreach ($todosPermisos as $permiso) {
                PermisosRol::firstOrCreate([
                    'id_permiso' => $permiso->id_permiso,
                    'id_rol' => $admin->id_rol,
                ]);
            }
        }

        // 2. Coordinador UPS
        if ($coordUps) {
            $nombres = [
                'crear_proyectos',
                'aprobar_proyectos',
                'asignar_tutor',
                'inscribir_alumnos',
                'subir_documentos',
                'revisar_documentos',
                'finalizar_proyectos',
                'ver_reportes',
            ];
            $permisos = Permiso::whereIn('nombre_permiso', $nombres)->get();
            foreach ($permisos as $permiso) {
                PermisosRol::firstOrCreate([
                    'id_permiso' => $permiso->id_permiso,
                    'id_rol' => $coordUps->id_rol,
                ]);
            }
        }

        // 3. Coordinador de Carrera
        if ($coordCarrera) {
            $nombres = [
                'crear_proyectos',
                'asignar_tutor',
                'inscribir_alumnos',
                'revisar_documentos',
                'ver_reportes',
            ];
            $permisos = Permiso::whereIn('nombre_permiso', $nombres)->get();
            foreach ($permisos as $permiso) {
                PermisosRol::firstOrCreate([
                    'id_permiso' => $permiso->id_permiso,
                    'id_rol' => $coordCarrera->id_rol,
                ]);
            }
        }

        // 4. Docente Tutor
        if ($tutor) {
            $nombres = [
                'subir_documentos',
                'revisar_documentos',
                'ver_reportes',
            ];
            $permisos = Permiso::whereIn('nombre_permiso', $nombres)->get();
            foreach ($permisos as $permiso) {
                PermisosRol::firstOrCreate([
                    'id_permiso' => $permiso->id_permiso,
                    'id_rol' => $tutor->id_rol,
                ]);
            }
        }

        // 5. Estudiante
        if ($estudiante) {
            $nombres = [
                'subir_documentos',
            ];
            $permisos = Permiso::whereIn('nombre_permiso', $nombres)->get();
            foreach ($permisos as $permiso) {
                PermisosRol::firstOrCreate([
                    'id_permiso' => $permiso->id_permiso,
                    'id_rol' => $estudiante->id_rol,
                ]);
            }
        }
    }
}
