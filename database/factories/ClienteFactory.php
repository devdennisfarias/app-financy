<?php

namespace Database\Factories;

use App\Models\Cliente;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


class ClienteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Cliente::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $fakerptBR = \Faker\Factory::create('pt_BR');
        return [
            'nome' => $fakerptBR->name,
            'cpf' => $fakerptBR->cpf,
            'figura_publica' => $this->faker->boolean(),
            'rg' => $this->faker->numberBetween(7),
            'data_exp' => $this->faker->date(),
            'orgao_emissor' => Str::random(10),
            'data_nascimento' => $this->faker->date(),
            'alfabetizado' => $this->faker->boolean(),
            'nome_pai' => $fakerptBR->name,
            'nome_mae' => $fakerptBR->name,
            'endereco' => $fakerptBR->address,
            'numero' => Str::random(10),
            'complemento' => Str::random(10),
            'nacionalidade' => Str::random(10),
            'naturalidade' => Str::random(10),
            'estado_civil' => Str::random(10),
            'orgao_1' => Str::random(10),
            'matricula_1' => $this->faker->numberBetween(1000000000, 9999999999),
            'especie_beneficio_1' => Str::random(10),
            'salario_1' => $this->faker->numberBetween(1000,9999),
            'banco_conta_1' => Str::random(10),
            'agencia_conta_1' => $this->faker->numberBetween(10000,99999),
            'conta_bancaria_1' => $this->faker->numberBetween(1000000,9999999),
            'orgao_2' => Str::random(10),
            'matricula_2' => $this->faker->numberBetween(1000000000,9999999999),
            'especie_beneficio_2' => Str::random(10),
            'salario_2' => $this->faker->numberBetween(1000,9999),
            'banco_conta_2' => Str::random(10),
            'agencia_conta_2'=> $this->faker->numberBetween(10000,55555),
            'conta_bancaria_2' => $this->faker->numberBetween(10000,55555),
            'telefone_1'=> $this->faker->numberBetween(1000000000,9999999999),
            'telefone_2'=> $this->faker->numberBetween(10000000000,99999999999),
            'telefone_3'=> $this->faker->numberBetween(10000000000,99999999999),
            'user_id' => $this->faker->numberBetween(1, 4),
        ];
    }
}
