<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAcessosExternosTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('acessos_externos', function (Blueprint $table) {
			$table->id();
			$table->string('nome');
			$table->string('link')->nullable();
			$table->string('usuario')->nullable();
			$table->string('senha')->nullable(); // sem criptografia
			$table->text('observacao')->nullable();

			$table->unsignedBigInteger('created_by')->nullable();
			$table->unsignedBigInteger('updated_by')->nullable();

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
		Schema::dropIfExists('acessos_externos');
	}
}
