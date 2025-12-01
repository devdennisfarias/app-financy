<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPromotoraComisssaoToPropostasTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('propostas', function (Blueprint $table) {
			$table->unsignedBigInteger('promotora_id')->nullable()->after('produto_id');
			$table->unsignedBigInteger('banco_id')->nullable()->after('promotora_id'); // se quiser gravar também
			$table->decimal('porcentagem_comissao_vendedor', 8, 4)->nullable()->after('banco_id');
			// opcional:
			// $table->decimal('valor_comissao_vendedor', 10, 2)->nullable()->after('porcentagem_comissao_vendedor');

			$table->foreign('promotora_id')->references('id')->on('promotoras');
			$table->foreign('banco_id')->references('id')->on('bancos');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('propostas', function (Blueprint $table) {
			//
		});
	}
}
