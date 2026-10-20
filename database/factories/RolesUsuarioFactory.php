<?php

namespace Database\Factories;

use App\Models\Rol;
use App\Models\RolesUsuario;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<RolesUsuario>
 */
class RolesUsuarioFactory extends Factory
{
    protected $model = RolesUsuario::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_usuario' => Usuario::factory(),
            'id_rol' => Rol::factory(),
        ];
    }
}
