<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePropostas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('propostas', function (Blueprint $table) {
            $table->id();
            $table->string('banco')->nullable();
            $table->string('orgao')->nullable();
            $table->string('tabela_digitada')->nullable();
            $table->string('vigencia_tabela')->nullable();
            $table->decimal('valor_bruto', 15, 2)->nullable();
            $table->decimal('valor_liquido_liberado', 15, 2)->nullable();
            $table->decimal('tx_juros', 2,1)->nullable();
            $table->decimal('valor_parcela', 15, 2)->nullable();
            $table->integer('qtd_parcelas')->nullable();
            $table->decimal('porcentagem_comissao_vendedor', 5,2)->nullable()->default(0);
            $table->timestamps();
            
            $table->unsignedBigInteger('cliente_id')->nullable();
            $table->foreign('cliente_id')->references('id')->on('clientes');

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');

            $table->unsignedBigInteger('status_atual_id')->nullable();
            $table->foreign('status_atual_id')->references('id')->on('status');

            $table->unsignedBigInteger('status_tipo_atual_id')->nullable();
            $table->foreign('status_tipo_atual_id')->references('id')->on('status_tipos');

            $table->unsignedBigInteger('produto_id')->nullable();
            $table->foreign('produto_id')->references('id')->on('produtos');

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
        Schema::dropIfExists('propostas');
    }
}
