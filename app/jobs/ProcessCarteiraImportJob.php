<?php

namespace App\Jobs;

use App\Events\LongOperationProgressUpdated;
use App\Models\Cliente;
use App\Models\LongOperation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessCarteiraImportJob implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	protected int $operationId;
	protected string $filePath;
	protected int $userId;

	/**
	 * @param int    $operationId ID da long_operations
	 * @param string $filePath    Caminho relativo no storage (ex.: imports/carteiras/xxxx.csv)
	 * @param int    $userId      Usuário dono da operação
	 */
	public function __construct(int $operationId, string $filePath, int $userId)
	{
		$this->operationId = $operationId;
		$this->filePath = $filePath;
		$this->userId = $userId;
	}

	public function handle()
	{
		$operation = LongOperation::find($this->operationId);

		if (!$operation) {
			return;
		}

		$operation->update([
			'status' => 'running',
			'started_at' => now(),
		]);

		$fullPath = storage_path('app/' . $this->filePath);

		if (!file_exists($fullPath)) {
			$operation->update([
				'status' => 'failed',
				'finished_at' => now(),
				'extra' => ['error' => 'Arquivo não encontrado'],
			]);

			event(new LongOperationProgressUpdated($operation->fresh()));
			return;
		}

		$processed = 0;
		$errors = [];

		if (($handle = fopen($fullPath, 'r')) !== false) {
			while (($row = fgetcsv($handle, 0, ';')) !== false) {
				// Ignora linhas totalmente vazias
				if (count(array_filter($row)) === 0) {
					continue;
				}

				// Se a primeira linha parecer cabeçalho, pula
				if ($processed === 0 && $this->looksLikeHeaderRow($row)) {
					$processed++;
					continue;
				}

				$nome = trim($row[0] ?? '');
				$tel1 = trim($row[1] ?? '');
				$tel2 = trim($row[2] ?? '');
				$tel3 = trim($row[3] ?? '');

				if ($nome === '' || $tel1 === '') {
					$errors[] = [
						'line' => $processed + 1,
						'reason' => 'Nome ou telefone1 vazio',
					];
				} else {
					try {
						Cliente::create([
							'nome' => $nome,
							'telefone' => $tel1,
							'telefone_2' => $tel2 ?: null,
							'telefone_3' => $tel3 ?: null,
							'user_id' => $this->userId,
							'primeiro_contato' => false,
							'respondeu' => false,
						]);
					} catch (\Throwable $e) {
						$errors[] = [
							'line' => $processed + 1,
							'reason' => $e->getMessage(),
						];
					}
				}

				$processed++;

				$operation->processed_items = $processed;
				$operation->extra = ['errors' => $errors];
				$operation->save();

				event(new LongOperationProgressUpdated($operation->fresh()));
			}

			fclose($handle);
		}

		$operation->status = 'completed';
		$operation->finished_at = now();
		$operation->save();

		event(new LongOperationProgressUpdated($operation->fresh()));
	}

	/**
	 * Verifica se a linha parece ser cabeçalho.
	 */
	protected function looksLikeHeaderRow(array $row): bool
	{
		$first = mb_strtolower(trim($row[0] ?? ''));

		return in_array($first, ['nome', 'name'], true);
	}
}
