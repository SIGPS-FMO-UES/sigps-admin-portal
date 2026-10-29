<?php

namespace Database\Factories;

use App\Models\Rol;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Rol>
 */
class RolFactory extends Factory
{
    protected $model = Rol::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->jobTitle().'_'.fake()->unique()->randomNumber(4);

        return [
            'name' => $name,
            'guard_name' => 'web',
        ];
    }
}
