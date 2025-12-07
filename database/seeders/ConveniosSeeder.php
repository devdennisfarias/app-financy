<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Convenio;

class ConveniosSeeder extends Seeder
{
	public function run()
	{
		$convenios = [
			['nome' => 'INSS', 'slug' => 'inss'],
			['nome' => 'Governo Federal', 'slug' => 'governo-federal'],
			['nome' => 'Governo Estadual', 'slug' => 'governo-estadual'],
			['nome' => 'Prefeituras', 'slug' => 'prefeituras'],
			['nome' => 'Forças Armadas', 'slug' => 'forcas-armadas'],
			['nome' => 'Empresas Privadas', 'slug' => 'empresas-privadas'],
			['nome' => 'Outros Convênios', 'slug' => 'outros'],
		];

		foreach ($convenios as $item) {
			Convenio::firstOrCreate(
				['slug' => $item['slug']],
				[
					'nome' => $item['nome'],
					'ativo' => true,
				]
			);
		}
	}
}
