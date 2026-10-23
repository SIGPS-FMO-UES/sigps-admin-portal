<?php

namespace Database\Factories;

use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<Usuario>
 */
class UsuarioFactory extends Factory
{
    protected $model = Usuario::class;

    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre_usuario' => fake()->unique()->userName(),
            'nombre_completo' => fake()->name(),
            'correo' => fake()->unique()->safeEmail(),
            'password' => static::$password ??= Hash::make('password'),
            'activo' => true,
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Estado para usuario inactivo.
     */
    public function inactivo(): static
    {
        return $this->state(fn (array $attributes) => [
            'activo' => false,
        ]);
    }
}
