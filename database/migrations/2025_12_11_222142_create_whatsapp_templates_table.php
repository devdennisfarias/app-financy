<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhatsappTemplatesTable extends Migration
{
	public function up()
	{
		Schema::create('whatsapp_templates', function (Blueprint $table) {
			$table->id();

			// Nome interno (ex.: refin_inss_oferta)
			$table->string('name');

			// ID real na plataforma Meta
			$table->string('meta_template_id');

			// marketing | utility | authentication, etc.
			$table->string('category', 50)->nullable();

			// pt_BR, en_US, etc.
			$table->string('language', 10)->default('pt_BR');

			// Corpo do template com placeholders
			$table->text('body')->nullable();

			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::dropIfExists('whatsapp_templates');
	}
}
