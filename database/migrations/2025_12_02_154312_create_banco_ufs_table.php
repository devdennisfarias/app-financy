<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBancoUfsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('banco_ufs', function (Blueprint $table) {
			$table->id();
			$table->foreignId('banco_id')
				->constrained('bancos')
				->onDelete('cascade');
			$table->string('uf', 2);
			$table->timestamps();

			$table->unique(['banco_id', 'uf']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('banco_ufs');
	}
}
