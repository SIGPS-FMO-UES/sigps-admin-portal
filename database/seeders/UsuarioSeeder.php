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
        $passwordHasheado = Hash::make('password123');

        // 1. Administrador General
        Usuario::firstOrCreate(
            ['nombre_usuario' => 'admin'],
            [
                'nombre_completo' => 'Administrador General UPS',
                'password' => $passwordHasheado,
                'activo' => true,
            ]
        );

        // 2. Coordinador UPS
        Usuario::firstOrCreate(
            ['nombre_usuario' => 'coord_ups'],
            [
                'nombre_completo' => 'Lic. Juan Pérez - Coordinador UPS',
                'password' => $passwordHasheado,
                'activo' => true,
            ]
        );

        // 3. Coordinador de Carrera
        Usuario::firstOrCreate(
            ['nombre_usuario' => 'coord_ing'],
            [
                'nombre_completo' => 'Ing. Carlos Martínez - Coordinador Ingeniería',
                'password' => $passwordHasheado,
                'activo' => true,
            ]
        );

        // 4. Docentes Tutores
        $tutores = [
            ['nombre_usuario' => 'tutor_lopez', 'nombre_completo' => 'Ing. Roberto López'],
            ['nombre_usuario' => 'tutor_rodriguez', 'nombre_completo' => 'Dra. María Rodríguez'],
            ['nombre_usuario' => 'tutor_garcia', 'nombre_completo' => 'MSc. Fernando García'],
        ];

        foreach ($tutores as $tutor) {
            Usuario::firstOrCreate(
                ['nombre_usuario' => $tutor['nombre_usuario']],
                [
                    'nombre_completo' => $tutor['nombre_completo'],
                    'password' => $passwordHasheado,
                    'activo' => true,
                ]
            );
        }

        // 5. Estudiantes
        for ($i = 1; $i <= 10; $i++) {
            $num = str_pad((string) $i, 2, '0', STR_PAD_LEFT);
            Usuario::firstOrCreate(
                ['nombre_usuario' => "alumno_{$num}"],
                [
                    'nombre_completo' => "Estudiante {$num} - Proyección Social",
                    'password' => $passwordHasheado,
                    'activo' => true,
                ]
            );
        }
    }
}
