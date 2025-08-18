<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PrestadorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome' => fake()->name(),
            'logradouro' => fake()->streetName(),
            'bairro' => fake()->name(),
            'numero' => fake()->name(),
            'latitude' => fake()->latitude(-19,-20),
            'longitude' => fake()->longitude(-43,-44),
            'cidade' => fake()->city(),
            'uf' => 'MG',
            'situacao' => 1,
        ];
    }


}
