<?php

namespace Database\Factories;

use App\Models\Servico;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PrestadorServicoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $servicos = Servico::all();
        return [
            'id_prestador' => fake()->numberBetween(0,3),
            'id_servico' => $servicos->random()->id,
            'km_saida' => fake()->numberBetween(15,30),
            'valor_saida' => fake()->randomFloat(1, 20, 30),
            'valor_km_excedente' => fake()->randomFloat(1, 20, 30),

        ];
    }
}
