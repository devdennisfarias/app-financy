<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StatusTipo;

class StatusTiposTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		// Mapeamos os tipos pela ordem pra manter a coerência dos IDs
		$tipos = [
			1 => 'Em Aberto',          // Proposta recém cadastrada
			2 => 'Em Andamento',       // Análise, pendência, aguardando averbação...
			3 => 'Automação / Robô',   // Integração com robô, esteira automática
			4 => 'Concluído',          // Finalizado, contrato pago, comissão paga
			5 => 'Cancelado',          // Proposta cancelada
		];

		foreach ($tipos as $id => $tipo) {
			StatusTipo::updateOrCreate(
				['id' => $id], // garante o ID estável
				[
					'tipo_status' => $tipo,
					'updated_at' => now(),
					'created_at' => now(),
				]
			);
		}
	}

}
