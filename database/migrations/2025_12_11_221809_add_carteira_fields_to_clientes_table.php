<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCarteiraFieldsToClientesTable extends Migration
{
	public function up()
	{
		Schema::table('clientes', function (Blueprint $table) {
			// Se ainda não houver user_id, remover essa linha
			if (!Schema::hasColumn('clientes', 'user_id')) {
				$table->unsignedBigInteger('user_id')->nullable()->after('id');
				$table->foreign('user_id')->references('id')->on('users')
					->onDelete('set null');
			}

			// Flag se já teve primeiro contato
			if (!Schema::hasColumn('clientes', 'primeiro_contato')) {
				$table->boolean('primeiro_contato')
					->default(false)
					->after('user_id');
			}

			// Flag se já respondeu
			if (!Schema::hasColumn('clientes', 'respondeu')) {
				$table->boolean('respondeu')
					->default(false)
					->after('primeiro_contato');
			}

			// Descrição livre para observações da carteira
			if (!Schema::hasColumn('clientes', 'descricao_carteira')) {
				$table->text('descricao_carteira')
					->nullable()
					->after('respondeu');
			}

			// Telefones extras (caso ainda não existam)
			if (!Schema::hasColumn('clientes', 'telefone_2')) {
				$table->string('telefone_2', 20)->nullable()->after('telefone');
			}
			if (!Schema::hasColumn('clientes', 'telefone_3')) {
				$table->string('telefone_3', 20)->nullable()->after('telefone_2');
			}
		});
	}

	public function down()
	{
		Schema::table('clientes', function (Blueprint $table) {
			if (Schema::hasColumn('clientes', 'descricao_carteira')) {
				$table->dropColumn('descricao_carteira');
			}
			if (Schema::hasColumn('clientes', 'respondeu')) {
				$table->dropColumn('respondeu');
			}
			if (Schema::hasColumn('clientes', 'primeiro_contato')) {
				$table->dropColumn('primeiro_contato');
			}
			if (Schema::hasColumn('clientes', 'telefone_3')) {
				$table->dropColumn('telefone_3');
			}
			if (Schema::hasColumn('clientes', 'telefone_2')) {
				$table->dropColumn('telefone_2');
			}

			if (Schema::hasColumn('clientes', 'user_id')) {
				$table->dropForeign(['user_id']);
				$table->dropColumn('user_id');
			}
		});
	}
}
