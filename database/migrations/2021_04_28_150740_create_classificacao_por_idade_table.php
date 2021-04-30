<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassificacaoPorIdadeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classificacao_por_idade', function (Blueprint $table) {
            $table->id();
            $table->integer('posicao');
            $table->smallInteger('idade');
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
        Schema::dropIfExists('classificacao_por_idade');
    }
}
