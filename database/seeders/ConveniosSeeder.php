<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Convenio;

class ConveniosSeeder extends Seeder
{
	public function run()
	{
		$items = [
			['nome' => 'INSS', 'slug' => 'inss'],
			['nome' => 'Governo Federal', 'slug' => 'gov-federal'],
			['nome' => 'Governo Estadual', 'slug' => 'gov-estadual'],
			['nome' => 'Governo Municipal', 'slug' => 'gov-municipal'],
			['nome' => 'Forças Armadas', 'slug' => 'forcas-armadas'],
			['nome' => 'Autarquia Federal', 'slug' => 'autarquia-federal'],
			['nome' => 'Empresa Privada', 'slug' => 'empresa-privada'],
			['nome' => 'Outros', 'slug' => 'outros'],
		];

		foreach ($items as $item) {
			Convenio::firstOrCreate(
				['slug' => $item['slug']],
				['nome' => $item['nome'], 'ativo' => true]
			);
		}
	}
}
