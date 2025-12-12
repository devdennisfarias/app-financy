<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Orgao;
use App\Models\Convenio;

class OrgaosSeeder extends Seeder
{
	public function run()
	{
		// Busca os convênios pelo slug
		$inss = Convenio::where('slug', 'inss')->first();
		$govFederal = Convenio::where('slug', 'governo-federal')->first();
		$govEstadual = Convenio::where('slug', 'governo-estadual')->first();
		$prefeituras = Convenio::where('slug', 'prefeituras')->first();
		$forcasArmadas = Convenio::where('slug', 'forcas-armadas')->first();
		$empresasPrivadas = Convenio::where('slug', 'empresas-privadas')->first();

		$orgaos = [
			// INSS
			['nome' => 'INSS', 'convenio_id' => optional($inss)->id],

			// Governo Federal
			['nome' => 'Receita Federal', 'convenio_id' => optional($govFederal)->id],
			['nome' => 'Ministério da Economia', 'convenio_id' => optional($govFederal)->id],

			// Governo Estadual
			['nome' => 'Governo do Estado', 'convenio_id' => optional($govEstadual)->id],
			['nome' => 'Secretaria de Educação Estadual', 'convenio_id' => optional($govEstadual)->id],

			// Prefeituras
			['nome' => 'Prefeitura Municipal', 'convenio_id' => optional($prefeituras)->id],

			// Forças Armadas
			['nome' => 'Exército Brasileiro', 'convenio_id' => optional($forcasArmadas)->id],
			['nome' => 'Marinha do Brasil', 'convenio_id' => optional($forcasArmadas)->id],
			['nome' => 'Aeronáutica', 'convenio_id' => optional($forcasArmadas)->id],

			// Empresas Privadas
			['nome' => 'Empresa Privada', 'convenio_id' => optional($empresasPrivadas)->id],
		];

		foreach ($orgaos as $item) {
			Orgao::firstOrCreate(
				[
					'nome' => $item['nome'],
					'convenio_id' => $item['convenio_id'],
				],
				[
					'ativo' => true,
				]
			);
		}
	}
}
