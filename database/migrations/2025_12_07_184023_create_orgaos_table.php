<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrgaosTable extends Migration
{
	public function up()
	{
		Schema::create('orgaos', function (Blueprint $table) {
			$table->id();
			$table->string('nome'); // Ex: Exército Brasileiro
			$table->unsignedBigInteger('convenio_id');
			$table->boolean('ativo')->default(true);
			$table->timestamps();

			$table->foreign('convenio_id')
				->references('id')
				->on('convenios')
				->onDelete('cascade');
		});
	}

	public function down()
	{
		Schema::dropIfExists('orgaos');
	}
}
