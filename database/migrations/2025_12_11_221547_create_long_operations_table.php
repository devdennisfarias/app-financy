<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLongOperationsTable extends Migration
{
	public function up()
	{
		Schema::create('long_operations', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('user_id')->nullable();

			// Tipo da operação: import_carteira, campaign_send, etc.
			$table->string('type', 50);

			// Descrição amigável para mostrar na UI
			$table->string('description')->nullable();

			// pending | running | completed | failed
			$table->string('status', 20)->default('pending');

			// Contador
			$table->unsignedInteger('total_items')->default(0);
			$table->unsignedInteger('processed_items')->default(0);

			// JSON com infos extras (erros por linha, configs, etc.)
			$table->json('extra')->nullable();

			$table->timestamp('started_at')->nullable();
			$table->timestamp('finished_at')->nullable();

			$table->timestamps();

			$table->foreign('user_id')->references('id')->on('users')
				->onDelete('set null');
		});
	}

	public function down()
	{
		Schema::dropIfExists('long_operations');
	}
}
