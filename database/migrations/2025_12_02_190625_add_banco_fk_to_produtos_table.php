<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBancoFkToProdutosTable extends Migration
{
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::table('produtos', function (Blueprint $table) {
			// Garante que a coluna exista, mas NÃO cria FK aqui
			if (!Schema::hasColumn('produtos', 'banco_id')) {
				$table->unsignedBigInteger('banco_id')
					->nullable()
					->after('id');
			}

			// NÃO criar foreign key aqui, porque outra migration
			// (AddBancoToProdutosTable) já faz isso e usa o mesmo nome
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::table('produtos', function (Blueprint $table) {
			if (Schema::hasColumn('produtos', 'banco_id')) {
				$table->dropColumn('banco_id');
			}
		});
	}
}
