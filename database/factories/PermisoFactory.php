<?php

namespace Database\Factories;

use App\Models\Permiso;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Permiso>
 */
class PermisoFactory extends Factory
{
    protected $model = Permiso::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre_permiso' => fake()->randomElement([
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
            ]),
        ];
    }
}
