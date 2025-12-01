<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBancoPromotoraTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('banco_promotora', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('banco_id');
			$table->unsignedBigInteger('promotora_id');
			$table->timestamps();

			$table->foreign('banco_id')->references('id')->on('bancos');
			$table->foreign('promotora_id')->references('id')->on('promotoras');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('banco_promotora');
	}
}
