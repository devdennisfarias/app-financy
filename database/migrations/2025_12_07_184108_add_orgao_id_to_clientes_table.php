<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrgaoIdToClientesTable extends Migration
{
	public function up()
	{
		Schema::table('clientes', function (Blueprint $table) {
			if (!Schema::hasColumn('clientes', 'orgao_id')) {
				$table->unsignedBigInteger('orgao_id')->nullable()->after('id');

				$table->foreign('orgao_id')
					->references('id')
					->on('orgaos')
					->onDelete('set null');
			}
		});
	}

	public function down()
	{
		Schema::table('clientes', function (Blueprint $table) {
			if (Schema::hasColumn('clientes', 'orgao_id')) {
				$table->dropForeign(['orgao_id']);
				$table->dropColumn('orgao_id');
			}
		});
	}
}
