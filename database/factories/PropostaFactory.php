<?php

namespace Database\Factories;


use App\Models\Proposta;
use Illuminate\Database\Eloquent\Factories\Factory;

use Illuminate\Support\Str;

class PropostaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Proposta::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'cliente_id' => $this->faker->numberBetween(1, 5),
            'user_id' => $this->faker->numberBetween(1, 4),
            'banco' => Str::random(10),
            'orgao' => Str::random(15),
            'tabela_digitada' => Str::random(5),
            'vigencia_tabela' => $this->faker->date(),
            'valor_bruto' => $this->faker->numberBetween(100000, 999999),
            'valor_liquido_liberado' => $this->faker->numberBetween(10000, 99999),
            'tx_juros' => $this->faker->numberBetween(1, 9),
            'valor_parcela' => $this->faker->numberBetween(1000, 1999),
            'qtd_parcelas' => $this->faker->numberBetween(24, 360),
            'status_atual_id' => $this->faker->numberBetween(1, 5),
            'status_tipo_atual_id' => $this->faker->numberBetween(1, 5),
            'produto_id' => 1,
        ];
    }
}
