<?php

namespace Database\Factories;

use App\Models\Documento;
use App\Models\DocumentosProyecto;
use App\Models\Proyecto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DocumentosProyecto>
 */
class DocumentosProyectoFactory extends Factory
{
    protected $model = DocumentosProyecto::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_proyecto' => Proyecto::factory(),
            'id_documento' => Documento::factory(),
        ];
    }
}
