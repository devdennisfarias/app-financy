<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableDocumentos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('documentos', function (Blueprint $table) {
            $table->id();
            $table->string('path');
            $table->string('extencao');
            $table->timestamps();

            $table->unsignedBigInteger('proposta_id')->nullable();
            $table->foreign('proposta_id')->references('id')->on('propostas');

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
        Schema::dropIfExists('documentos');
    }
}
