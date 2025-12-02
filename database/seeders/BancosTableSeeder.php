<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Banco;
use Illuminate\Support\Facades\DB;

class BancosTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		$bancos = [
			['codigo' => '001', 'nome' => 'Banco do Brasil S.A.'],
			['codigo' => '033', 'nome' => 'Banco Santander (Brasil) S.A.'],
			['codigo' => '104', 'nome' => 'Caixa Econômica Federal'],
			['codigo' => '237', 'nome' => 'Banco Bradesco S.A.'],
			['codigo' => '341', 'nome' => 'Itaú Unibanco S.A.'],
			['codigo' => '077', 'nome' => 'Banco Inter S.A.'],
			['codigo' => '260', 'nome' => 'Nu Pagamentos S.A. (Nubank)'],
			['codigo' => '212', 'nome' => 'Banco Original S.A.'],
			['codigo' => '756', 'nome' => 'Sicoob - Banco Cooperativo do Brasil S.A.'],
			['codigo' => '748', 'nome' => 'Sicredi - Banco Cooperativo Sicredi S.A.'],
			['codigo' => '655', 'nome' => 'Banco Votorantim S.A.'],
			['codigo' => '422', 'nome' => 'Banco Safra S.A.'],
		];

		// todas as UFs (BR)
		$ufs = [
			'AC',
			'AL',
			'AP',
			'AM',
			'BA',
			'CE',
			'DF',
			'ES',
			'GO',
			'MA',
			'MT',
			'MS',
			'MG',
			'PA',
			'PB',
			'PR',
			'PE',
			'PI',
			'RJ',
			'RN',
			'RS',
			'RO',
			'RR',
			'SC',
			'SP',
			'SE',
			'TO'
		];

		foreach ($bancos as $b) {
			// cria/atualiza o banco como instituição tipo 'banco'
			$banco = Banco::updateOrCreate(
				['codigo' => $b['codigo']],
				[
					'nome' => $b['nome'],
					'tipo' => 'banco',
				]
			);

			// vincula todos os estados direto na tabela banco_ufs
			foreach ($ufs as $uf) {
				DB::table('banco_ufs')->updateOrInsert(
					[
						'banco_id' => $banco->id,
						'uf' => $uf,
					],
					[
						'created_at' => now(),
						'updated_at' => now(),
					]
				);
			}
		}
	}
}
