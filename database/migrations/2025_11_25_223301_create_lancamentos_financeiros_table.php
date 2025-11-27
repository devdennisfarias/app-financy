<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLancamentosFinanceirosTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('lancamentos_financeiros', function (Blueprint $table) {
			$table->id();

			// receita / despesa
			$table->enum('tipo', ['receita', 'despesa']);

			// pagar / receber (pra facilitar as telas)
			$table->enum('natureza', ['pagar', 'receber']);

			// vínculos
			$table->foreignId('conta_bancaria_id')->nullable()->constrained('contas_bancarias');
			$table->unsignedBigInteger('proposta_id')->nullable(); // se quiser ligar com propostas
			$table->unsignedBigInteger('cliente_id')->nullable();

			// descrição
			$table->string('descricao');
			$table->string('categoria')->nullable(); // Ex: Comissão, Tarifa, Aluguel

			// datas
			$table->date('data_competencia')->nullable();
			$table->date('data_vencimento')->nullable();
			$table->date('data_pagamento')->nullable();

			// valores
			$table->decimal('valor_previsto', 15, 2);
			$table->decimal('valor_pago', 15, 2)->nullable();

			// status: aberto / pago / atrasado / cancelado
			$table->enum('status', ['aberto', 'pago', 'atrasado', 'cancelado'])->default('aberto');

			// controle
			$table->foreignId('user_id')->nullable()->constrained('users');
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
		Schema::dropIfExists('lancamentos_financeiros');
	}
}
