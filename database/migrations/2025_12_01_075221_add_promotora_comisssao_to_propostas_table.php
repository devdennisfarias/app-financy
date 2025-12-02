<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPromotoraComisssaoToPropostasTable extends Migration
{
	public function up()
	{
		Schema::table('propostas', function (Blueprint $table) {
			if (!Schema::hasColumn('propostas', 'promotora_id')) {
				$table->foreignId('promotora_id')->nullable()->after('produto_id');
			}

			if (!Schema::hasColumn('propostas', 'banco_id')) {
				$table->foreignId('banco_id')->nullable()->after('promotora_id');
			}

			if (!Schema::hasColumn('propostas', 'porcentagem_comissao_vendedor')) {
				$table->decimal('porcentagem_comissao_vendedor', 8, 4)->nullable()->after('banco_id');
			}
		});
	}

	public function down()
	{
		Schema::table('propostas', function (Blueprint $table) {
			if (Schema::hasColumn('propostas', 'promotora_id')) {
				$table->dropForeign(['promotora_id']);
				$table->dropColumn('promotora_id');
			}

			if (Schema::hasColumn('propostas', 'banco_id')) {
				$table->dropForeign(['banco_id']);
				$table->dropColumn('banco_id');
			}

			if (Schema::hasColumn('propostas', 'porcentagem_comissao_vendedor')) {
				$table->dropColumn('porcentagem_comissao_vendedor');
			}
		});
	}
}

