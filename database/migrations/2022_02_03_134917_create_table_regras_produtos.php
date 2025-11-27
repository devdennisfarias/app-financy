<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableRegrasProdutos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regras_produtos', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('regra_id')->nullable();
            $table->foreign('regra_id')->references('id')->on('regras');

            $table->unsignedBigInteger('produto_id')->nullable();
            $table->foreign('produto_id')->references('id')->on('produtos');

            $table->decimal('comissao', 5,2)->nullable();

            $table->softDeletes();
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
        Schema::dropIfExists('regras_produtos');
    }
}
