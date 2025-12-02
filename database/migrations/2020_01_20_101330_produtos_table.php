<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProdutosTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('produtos', function (Blueprint $table) {
			$table->id();
			$table->string('produto');
			$table->string('descricao')->nullable();
			// outros campos que você já tem...

			// EM VEZ DE:
			// $table->foreignId('banco_id')->nullable()->constrained('bancos');

			// USE APENAS:
			$table->unsignedBigInteger('banco_id')->nullable();

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
		Schema::dropIfExists('produtos');
	}
}
