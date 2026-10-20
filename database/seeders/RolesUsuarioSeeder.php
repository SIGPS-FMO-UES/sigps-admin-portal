<?php

namespace Database\Seeders;

use App\Models\Rol;
use App\Models\RolesUsuario;
use App\Models\Usuario;
use Illuminate\Database\Seeder;

class RolesUsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRol = Rol::where('nombre_rol', 'Administrador')->first();
        $coordUpsRol = Rol::where('nombre_rol', 'Coordinador UPS')->first();
        $coordCarreraRol = Rol::where('nombre_rol', 'Coordinador de Carrera')->first();
        $tutorRol = Rol::where('nombre_rol', 'Docente Tutor')->first();
        $estudianteRol = Rol::where('nombre_rol', 'Estudiante')->first();

        // 1. Asignar Admin
        $admin = Usuario::where('nombre_usuario', 'admin')->first();
        if ($admin && $adminRol) {
            RolesUsuario::firstOrCreate([
                'id_usuario' => $admin->id_usuario,
                'id_rol' => $adminRol->id_rol,
            ]);
        }

        // 2. Asignar Coordinador UPS
        $coordUps = Usuario::where('nombre_usuario', 'coord_ups')->first();
        if ($coordUps && $coordUpsRol) {
            RolesUsuario::firstOrCreate([
                'id_usuario' => $coordUps->id_usuario,
                'id_rol' => $coordUpsRol->id_rol,
            ]);
        }

        // 3. Asignar Coordinador Carrera
        $coordIng = Usuario::where('nombre_usuario', 'coord_ing')->first();
        if ($coordIng && $coordCarreraRol) {
            RolesUsuario::firstOrCreate([
                'id_usuario' => $coordIng->id_usuario,
                'id_rol' => $coordCarreraRol->id_rol,
            ]);
        }

        // 4. Asignar Tutores
        $tutores = Usuario::whereIn('nombre_usuario', ['tutor_lopez', 'tutor_rodriguez', 'tutor_garcia'])->get();
        if ($tutorRol) {
            foreach ($tutores as $tutor) {
                RolesUsuario::firstOrCreate([
                    'id_usuario' => $tutor->id_usuario,
                    'id_rol' => $tutorRol->id_rol,
                ]);
            }
        }

        // 5. Asignar Estudiantes
        $estudiantes = Usuario::where('nombre_usuario', 'like', 'alumno_%')->get();
        if ($estudianteRol) {
            foreach ($estudiantes as $estudiante) {
                RolesUsuario::firstOrCreate([
                    'id_usuario' => $estudiante->id_usuario,
                    'id_rol' => $estudianteRol->id_rol,
                ]);
            }
        }
    }
}
