<?php

namespace Database\Seeders;

use App\Models\Usuario;
use Illuminate\Database\Seeder;

class RolesUsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Asignar Admin
        $admin = Usuario::where('nombre_usuario', 'admin')->first();
        if ($admin) {
            $admin->syncRoles(['Administrador']);
        }

        // 2. Asignar Coordinador UPS
        $coordUps = Usuario::where('nombre_usuario', 'coord_ups')->first();
        if ($coordUps) {
            $coordUps->syncRoles(['Coordinador UPS']);
        }

        // 2b. Asignar Auxiliar UPS
        $auxUps = Usuario::where('nombre_usuario', 'aux_ups')->first();
        if ($auxUps) {
            $auxUps->syncRoles(['Auxiliar UPS']);
        }

        // 3. Asignar Coordinador Carrera
        $coordIng = Usuario::where('nombre_usuario', 'coord_ing')->first();
        if ($coordIng) {
            $coordIng->syncRoles(['Coordinador de Carrera']);
        }

        // 4. Asignar Tutores
        $tutores = Usuario::whereIn('nombre_usuario', ['tutor_lopez', 'tutor_rodriguez', 'tutor_garcia'])->get();
        foreach ($tutores as $tutor) {
            $tutor->syncRoles(['Docente Tutor']);
        }

        // 5. Asignar Estudiantes
        $estudiantes = Usuario::where('nombre_usuario', 'like', 'alumno_%')
            ->orWhere('nombre_usuario', 'like', '2024-%')
            ->get();
        foreach ($estudiantes as $estudiante) {
            $estudiante->syncRoles(['Estudiante']);
        }
    }
}
