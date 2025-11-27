<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		$statusList = [
			[
				'status' => 'Cadastrada',
				'status_tipo_id' => 1, // Em Aberto
			],
			[
				'status' => 'Em Andamento',
				'status_tipo_id' => 2, // Em Andamento
			],
			[
				'status' => 'Pendenciada',
				'status_tipo_id' => 2, // Em Andamento
			],
			[
				'status' => 'Aguardando Averbação',
				'status_tipo_id' => 2, // Em Andamento
			],
			[
				'status' => 'Integração com Robô',
				'status_tipo_id' => 3, // Automação / Robô
			],
			[
				'status' => 'Finalizado',
				'status_tipo_id' => 4, // Concluído
			],
			[
				'status' => 'Contrato Pago',
				'status_tipo_id' => 4, // Concluído
			],
			[
				'status' => 'Comissão Paga',
				'status_tipo_id' => 4, // Concluído
			],
			[
				'status' => 'Cancelado',
				'status_tipo_id' => 5, // Cancelado
			],
		];

		foreach ($statusList as $data) {
			Status::updateOrCreate(
				['status' => $data['status']], // chave única textual
				[
					'status_tipo_id' => $data['status_tipo_id'],
					'updated_at' => now(),
					'created_at' => now(),
				]
			);
		}
	}

}
