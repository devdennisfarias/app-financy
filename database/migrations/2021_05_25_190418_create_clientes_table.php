<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('clientes', function (Blueprint $table) {
			$table->id();
			$table->string('nome');
			$table->string('cpf')->unique();
			$table->string('rg')->nullable();
			$table->date('data_exp')->nullable();
			$table->string('orgao_emissor')->nullable();
			$table->date('data_nascimento');
			$table->boolean('alfabetizado')->nullable();
			$table->boolean('figura_publica')->nullable();
			$table->string('nome_pai')->nullable();
			$table->string('nome_mae');
			$table->string('email')->nullable();
			$table->string('cep')->nullable();
			$table->string('endereco')->nullable();
			$table->string('numero')->nullable();
			$table->string('bairro')->nullable();
			$table->string('cidade')->nullable();
			$table->string('estado')->nullable();
			$table->string('complemento')->nullable();
			$table->string('nacionalidade')->nullable();
			$table->string('naturalidade')->nullable();
			$table->string('estado_civil')->nullable();
			$table->string('orgao_1')->nullable();
			$table->string('matricula_1')->nullable();
			$table->string('especie_beneficio_1')->nullable();
			$table->decimal('salario_1', 15, 2)->nullable();
			$table->string('banco_conta_1')->nullable();
			$table->string('agencia_conta_1')->nullable();
			$table->string('conta_bancaria_1')->nullable();
			$table->string('orgao_2')->nullable();
			$table->string('matricula_2')->nullable();
			$table->string('especie_beneficio_2')->nullable();
			$table->decimal('salario_2', 15, 2)->nullable();
			$table->string('banco_conta_2')->nullable();
			$table->string('agencia_conta_2')->nullable();
			$table->string('conta_bancaria_2')->nullable();
			$table->string('telefone_1');
			$table->string('telefone_2')->nullable();
			$table->string('telefone_3')->nullable();
			$table->string('convenio')->nullable();
			$table->string('matricula')->nullable();

			$table->timestamps();

			$table->unsignedBigInteger('user_id')->nullable();
			$table->foreign('user_id')->references('id')->on('users');


			$table->softDeletes();

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('clientes');
	}
}
