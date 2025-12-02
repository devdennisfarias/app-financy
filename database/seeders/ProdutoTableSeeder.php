<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use App\Models\Produto;
use App\Models\Banco;

class ProdutoTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
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

		// se quiser limpar tudo antes:
		Schema::disableForeignKeyConstraints();
		Produto::truncate();
		Schema::enableForeignKeyConstraints();

		$instituicoes = Banco::all();

		foreach ($instituicoes as $inst) {
			foreach ($produtos as $nome) {
				Produto::create([
					'produto' => $nome,
					'descricao' => null,
					'banco_id' => $inst->id, // vincula a CADA instituição
					'created_at' => now(),
					'updated_at' => now(),
				]);
			}
		}

		// Se quiser ainda criar produtos genéricos (sem banco), descomenta:
		/*
		foreach ($produtos as $nome) {
				Produto::create([
						'produto'    => $nome,
						'descricao'  => null,
						'banco_id'   => null,
						'created_at' => now(),
						'updated_at' => now(),
				]);
		}
		*/
	}
}
