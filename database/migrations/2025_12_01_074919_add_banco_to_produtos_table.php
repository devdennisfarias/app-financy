<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBancoToProdutosTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('produtos', function (Blueprint $table) {
			$table->unsignedBigInteger('banco_id')->nullable()->after('id');
			$table->foreign('banco_id')->references('id')->on('bancos');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('produtos', function (Blueprint $table) {
			//
		});
	}
}
