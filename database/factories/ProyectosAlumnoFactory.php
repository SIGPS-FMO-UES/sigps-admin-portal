<?php

namespace Database\Factories;

use App\Models\Proyecto;
use App\Models\ProyectosAlumno;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProyectosAlumno>
 */
class ProyectosAlumnoFactory extends Factory
{
    protected $model = ProyectosAlumno::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_alumno' => Usuario::factory(),
            'id_proyecto' => Proyecto::factory(),
        ];
    }
}
