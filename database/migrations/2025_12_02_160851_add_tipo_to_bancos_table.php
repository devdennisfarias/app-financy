<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTipoToBancosTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('bancos', function (Blueprint $table) {
			$table->string('tipo', 30)
				->default('banco')
				->after('nome'); // ou onde fizer mais sentido
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('bancos', function (Blueprint $table) {
			$table->dropColumn('tipo');
		});
	}
}
