<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConveniosTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('convenios', function (Blueprint $table) {
			$table->id();
			$table->string('nome');      // ex: INSS, Governo Federal, Forças Armadas
			$table->string('slug')->nullable(); // opcional, pra uso interno
			$table->boolean('ativo')->default(true);
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('convenios');
	}
}
