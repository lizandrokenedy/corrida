<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassificacaoGeralTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classificacao_geral', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('posicao');
            $table->unsignedBigInteger('corredor_id');
            $table->unsignedBigInteger('prova_id');
            $table->foreign('corredor_id')->references('id')->on('corredores');
            $table->foreign('prova_id')->references('id')->on('provas');
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
        Schema::dropIfExists('classificacao_geral');
    }
}
