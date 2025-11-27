<?php

namespace Database\Seeders;

use App\Models\Produto;
use Illuminate\Database\Seeder;

class ProdutoTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$produtos = [
			'Contrato Novo',
			'Refinanciamento',
			'Portabilidade',
			'Portabilidade + Refin',
			'Cartão Consignado',
			'Cartão Benefício',
			'Crédito Pessoal',
			'Crédito com Limite do Cartão',
		];

		foreach ($produtos as $nome) {
			Produto::create([
				'produto' => $nome,
				'created_at' => now(),
				'updated_at' => now(),
			]);
		}
	}

}
