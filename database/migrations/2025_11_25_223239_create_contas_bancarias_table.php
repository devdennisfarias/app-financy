<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContasBancariasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contas_bancarias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('banco_id')->constrained('bancos');
            $table->string('nome'); // Caixa Operacional, Conta Principal, etc.
            $table->string('agencia')->nullable();
            $table->string('conta')->nullable();
            $table->string('tipo_conta')->nullable(); // corrente, poupança...
            $table->decimal('saldo_inicial', 15, 2)->default(0);
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
        Schema::dropIfExists('contas_bancarias');
    }
}
