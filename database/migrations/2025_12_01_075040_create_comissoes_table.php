<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComissoesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('comissoes', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('produto_id');
			$table->unsignedBigInteger('banco_id')->nullable();
			$table->unsignedBigInteger('promotora_id')->nullable();

			$table->string('tipo_comissao')->default('vendedor'); // vendedor, loja, etc.
			$table->decimal('percentual', 8, 4)->nullable();      // 5.5000 = 5,5%
			$table->decimal('valor_fixo', 10, 2)->nullable();

			$table->date('vigencia_inicio')->nullable();
			$table->date('vigencia_fim')->nullable();
			$table->boolean('ativo')->default(true);

			$table->timestamps();

			$table->foreign('produto_id')->references('id')->on('produtos');
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
		Schema::dropIfExists('comissoes');
	}
}
