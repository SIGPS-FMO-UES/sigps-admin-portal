<?php

namespace Database\Factories;

use App\Models\Permiso;
use App\Models\PermisosRol;
use App\Models\Rol;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PermisosRol>
 */
class PermisosRolFactory extends Factory
{
    protected $model = PermisosRol::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_permiso' => Permiso::factory(),
            'id_rol' => Rol::factory(),
        ];
    }
}
