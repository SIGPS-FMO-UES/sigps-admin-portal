<?php

namespace Database\Factories;

use App\Models\Documento;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Documento>
 */
class DocumentoFactory extends Factory
{
    protected $model = Documento::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tipo = fake()->randomElement([
            'solicitud',
            'inscripcion',
            'anteproyecto',
            'mitad_proyecto',
            'memoria',
            'otro',
        ]);

        return [
            'nombre_documento' => ucfirst($tipo).' - '.fake()->words(2, true).'.pdf',
            'url_documento' => 'https://sigps.ues.edu.sv/storage/documentos/'.fake()->slug().'.pdf',
            'tipo' => $tipo,
        ];
    }
}
