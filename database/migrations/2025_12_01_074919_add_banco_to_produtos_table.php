<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBancoToProdutosTable extends Migration
{
	/**
	 * Run the migrations.
	 */
	public function up()
	{
		Schema::table('produtos', function (Blueprint $table) {

			// Adiciona coluna se não existir
			if (!Schema::hasColumn('produtos', 'banco_id')) {
				$table->unsignedBigInteger('banco_id')->nullable()->after('id');
			}

			// Só cria FK se possível (tabela bancos já existir)
			if (Schema::hasTable('bancos')) {
				// Evita duplicação da FK
				try {
					$table->foreign('banco_id')
						->references('id')
						->on('bancos')
						->onDelete('set null');
				} catch (\Exception $e) {
					// ignora erro caso FK já exista
				}
			}
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down()
	{
		Schema::table('produtos', function (Blueprint $table) {
			// remove a FK caso exista
			try {
				$table->dropForeign(['banco_id']);
			} catch (\Exception $e) {
			}

			// remove coluna se quiser:
			// if (Schema::hasColumn('produtos', 'banco_id')) {
			//     $table->dropColumn('banco_id');
			// }
		});
	}
}
