<?php

namespace Database\Seeders;

use App\Models\Usuario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Asegurar que los roles base y sus permisos existan
        $this->call([
            RolSeeder::class,
            PermisoSeeder::class,
            PermisosRolSeeder::class,
        ]);

        $passwordHasheado = Hash::make('password123');

        // 1. Administrador General
        $admin = Usuario::updateOrCreate(
            ['nombre_usuario' => 'admin'],
            [
                'nombre_completo' => 'Administrador General UPS',
                'correo' => 'admin@ues.edu.sv',
                'password' => $passwordHasheado,
                'activo' => true,
            ]
        );
        $admin->syncRoles(['Administrador']);

        // 2. Coordinador UPS
        $coordUps = Usuario::updateOrCreate(
            ['nombre_usuario' => 'coord_ups'],
            [
                'nombre_completo' => 'Lic. Juan Pérez - Coordinador UPS',
                'correo' => 'coord_ups@ues.edu.sv',
                'password' => $passwordHasheado,
                'activo' => true,
            ]
        );
        $coordUps->syncRoles(['Coordinador UPS']);

        // 2b. Auxiliar / Secretaría UPS (ACT-AUX)
        $auxUps = Usuario::updateOrCreate(
            ['nombre_usuario' => 'aux_ups'],
            [
                'nombre_completo' => 'Licda. Patricia Gómez - Auxiliar UPS',
                'correo' => 'aux_ups@ues.edu.sv',
                'password' => $passwordHasheado,
                'activo' => true,
            ]
        );
        $auxUps->syncRoles(['Auxiliar UPS']);

        // 3. Coordinador de Carrera
        $coordIng = Usuario::updateOrCreate(
            ['nombre_usuario' => 'coord_ing'],
            [
                'nombre_completo' => 'Ing. Carlos Martínez - Coordinador Ingeniería',
                'correo' => 'coord_ing@ues.edu.sv',
                'password' => $passwordHasheado,
                'activo' => true,
            ]
        );
        $coordIng->syncRoles(['Coordinador de Carrera']);

        // 4. Docentes Tutores
        $tutores = [
            ['nombre_usuario' => 'tutor_lopez', 'nombre_completo' => 'Ing. Roberto López', 'correo' => 'tutor_lopez@ues.edu.sv'],
            ['nombre_usuario' => 'tutor_rodriguez', 'nombre_completo' => 'Dra. María Rodríguez', 'correo' => 'tutor_rodriguez@ues.edu.sv'],
            ['nombre_usuario' => 'tutor_garcia', 'nombre_completo' => 'MSc. Fernando García', 'correo' => 'tutor_garcia@ues.edu.sv'],
        ];

        foreach ($tutores as $tutorData) {
            $tutor = Usuario::updateOrCreate(
                ['nombre_usuario' => $tutorData['nombre_usuario']],
                [
                    'nombre_completo' => $tutorData['nombre_completo'],
                    'correo' => $tutorData['correo'],
                    'password' => $passwordHasheado,
                    'activo' => true,
                ]
            );
            $tutor->syncRoles(['Docente Tutor']);
        }

        // 5. Estudiantes
        $estudiantesData = [
            ['carnet' => '2024-0185', 'nombre' => 'Ana Beatriz Mendoza Solís', 'correo' => '2024-0185@ues.edu.sv'],
            ['carnet' => '2024-0192', 'nombre' => 'Carlos Eduardo Ramos García', 'correo' => '2024-0192@ues.edu.sv'],
            ['carnet' => '2024-0201', 'nombre' => 'Gabriela María López Portillo', 'correo' => '2024-0201@ues.edu.sv'],
            ['carnet' => '2024-0216', 'nombre' => 'José Alexander Martínez Rivera', 'correo' => '2024-0216@ues.edu.sv'],
            ['carnet' => '2024-0223', 'nombre' => 'Valeria Sofía Hernández Castro', 'correo' => '2024-0223@ues.edu.sv'],
            ['carnet' => '2024-0237', 'nombre' => 'Diego Alejandro Cruz Flores', 'correo' => '2024-0237@ues.edu.sv'],
            ['carnet' => '2024-0244', 'nombre' => 'Fátima Guadalupe Pineda Reyes', 'correo' => '2024-0244@ues.edu.sv'],
            ['carnet' => '2024-0258', 'nombre' => 'Rodrigo Ernesto Vásquez Molina', 'correo' => '2024-0258@ues.edu.sv'],
            ['carnet' => '2024-0271', 'nombre' => 'Camila Marcela Aguilar Romero', 'correo' => '2024-0271@ues.edu.sv'],
            ['carnet' => '2024-0290', 'nombre' => 'Kevin Daniel Salazar Cornejo', 'correo' => '2024-0290@ues.edu.sv'],
        ];

        foreach ($estudiantesData as $est) {
            $estudiante = Usuario::updateOrCreate(
                ['nombre_usuario' => $est['carnet']],
                [
                    'nombre_completo' => $est['nombre'],
                    'correo' => $est['correo'],
                    'password' => $passwordHasheado,
                    'activo' => true,
                ]
            );
            $estudiante->syncRoles(['Estudiante']);
        }

        for ($i = 1; $i <= 10; $i++) {
            $num = str_pad((string) $i, 2, '0', STR_PAD_LEFT);
            $alumno = Usuario::updateOrCreate(
                ['nombre_usuario' => "alumno_{$num}"],
                [
                    'nombre_completo' => "Estudiante {$num} - Proyección Social",
                    'correo' => "alumno_{$num}@ues.edu.sv",
                    'password' => $passwordHasheado,
                    'activo' => true,
                ]
            );
            $alumno->syncRoles(['Estudiante']);
        }
    }
}
