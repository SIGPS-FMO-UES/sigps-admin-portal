<?php

namespace Database\Factories;

use App\Models\Proyecto;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Proyecto>
 */
class ProyectoFactory extends Factory
{
    protected $model = Proyecto::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre_proyecto' => 'Proyecto de '.fake()->catchPhrase(),
            'codigo_proyecto' => fake()->unique()->numberBetween(1000, 99999),
            'estado' => fake()->randomElement([
                'solicitado',
                'en_inscripcion',
                'en_proceso',
                'en_finalizacion',
                'finalizado',
            ]),
            'tutor_id' => null,
        ];
    }

    /**
     * Estado con docente tutor asignado.
     */
    public function conTutor(?Usuario $tutor = null): static
    {
        return $this->state(fn (array $attributes) => [
            'tutor_id' => $tutor?->id_usuario ?? Usuario::factory(),
        ]);
    }
}
