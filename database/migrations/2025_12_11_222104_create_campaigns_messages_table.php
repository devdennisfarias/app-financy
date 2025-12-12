<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignsMessagesTable extends Migration
{
	public function up()
	{
		Schema::create('campaign_messages', function (Blueprint $table) {
			$table->id();

			$table->unsignedBigInteger('campaign_id');
			$table->unsignedBigInteger('cliente_id')->nullable();

			// Telefone que será usado no envio
			$table->string('phone', 20);

			// pending | queued | sent | delivered | read | failed
			$table->string('status', 20)->default('pending');

			// ID retornado pela API do WhatsApp
			$table->string('provider_message_id')->nullable();

			$table->string('error_code', 50)->nullable();
			$table->text('error_message')->nullable();

			$table->timestamp('sent_at')->nullable();
			$table->timestamp('delivered_at')->nullable();
			$table->timestamp('read_at')->nullable();

			$table->timestamps();

			$table->foreign('campaign_id')->references('id')->on('campaigns')
				->onDelete('cascade');

			$table->foreign('cliente_id')->references('id')->on('clientes')
				->onDelete('set null');
		});
	}

	public function down()
	{
		Schema::dropIfExists('campaign_messages');
	}
}
