<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignTable extends Migration
{
	public function up()
	{
		Schema::create('campaigns', function (Blueprint $table) {
			$table->id();

			$table->unsignedBigInteger('user_id')->nullable();

			$table->string('name');

			// Filtros da carteira: orgão, convênio, tipo de cliente, etc.
			$table->json('segment_filters')->nullable();

			// Template oficial da Meta (opcional)
			$table->unsignedBigInteger('message_template_id')->nullable();

			// Mensagem customizada (quando permitido)
			$table->text('custom_message')->nullable();

			// Quando a campanha deve começar
			$table->timestamp('scheduled_at')->nullable();

			// draft | scheduled | running | paused | completed | failed
			$table->string('status', 20)->default('draft');

			// Config do envio (delay, limite/hora, etc.)
			$table->json('config')->nullable();

			// Link com a operação longa
			$table->unsignedBigInteger('long_operation_id')->nullable();

			$table->timestamps();

			$table->foreign('user_id')->references('id')->on('users')
				->onDelete('set null');

			$table->foreign('long_operation_id')->references('id')->on('long_operations')
				->onDelete('set null');
		});
	}

	public function down()
	{
		Schema::dropIfExists('campaigns');
	}
}
