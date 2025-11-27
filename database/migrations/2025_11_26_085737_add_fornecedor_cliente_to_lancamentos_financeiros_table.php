<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFornecedorClienteToLancamentosFinanceirosTable extends Migration
{
    public function up()
    {
        Schema::table('lancamentos_financeiros', function (Blueprint $table) {

            // adiciona fornecedor_id se ainda não existir
            if (!Schema::hasColumn('lancamentos_financeiros', 'fornecedor_id')) {
                $table->unsignedBigInteger('fornecedor_id')
                    ->nullable()
                    ->after('conta_bancaria_id');
            }

            // adiciona cliente_id se ainda não existir
            if (!Schema::hasColumn('lancamentos_financeiros', 'cliente_id')) {
                $table->unsignedBigInteger('cliente_id')
                    ->nullable()
                    ->after('fornecedor_id');
            }
        });
    }

    public function down()
    {
        Schema::table('lancamentos_financeiros', function (Blueprint $table) {

            if (Schema::hasColumn('lancamentos_financeiros', 'fornecedor_id')) {
                $table->dropColumn('fornecedor_id');
            }

            // só remove cliente_id se você quiser mesmo
            // (se ela já existia antes, pode comentar isso)
            if (Schema::hasColumn('lancamentos_financeiros', 'cliente_id')) {
                $table->dropColumn('cliente_id');
            }
        });
    }
}
