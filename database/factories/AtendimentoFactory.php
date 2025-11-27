<?php

namespace Database\Factories;

use App\Models\Atendimento;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AtendimentoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Atendimento::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'descricao' => Str::random(10),
            'proposta_id' => $this->faker->numberBetween(1,5),
            'status_id' => $this->faker->numberBetween(1,4), 
        ];
    }
}
