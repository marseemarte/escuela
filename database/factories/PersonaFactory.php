<?php

namespace Database\Factories;

use App\Models\Personas\Persona;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Personas\Persona>
 */
class PersonaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Persona::class;

    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'dni' => $this->faker->unique()->numberBetween(10000000, 99999999),
            'apellido' => \Illuminate\Support\Str::upper($this->faker->lastName()),
            'nombre' => \Illuminate\Support\Str::upper($this->faker->firstName()),
            'fechan' => $this->faker->date(),
            'sexo' => $this->faker->randomElement(['M', 'F']),
            'domicilio' => \Illuminate\Support\Str::upper($this->faker->streetAddress()),
            'id_localidad' => $this->faker->numberBetween(1, 100), // Rango de localidades
            'pass' => 'password', // Mejorado: usar password estándar que se hasheará
            'telefono' => $this->faker->phoneNumber(),
            'mail' => $this->faker->unique()->safeEmail(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
