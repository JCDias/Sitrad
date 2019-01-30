<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoricosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historicos', function(Blueprint $table) {
           $table->increments('id');

           $table->unsignedInteger('solicitacao_id');
           $table->unsignedInteger('user_id');
           $table->unsignedInteger('acao_id');
           $table->string('valor')->nullable();

           //Controle do laravel
           $table->timestampsTz();
           $table->softDeletes();

           //Chave estrangeira
           $table->foreign('solicitacao_id')->references('id')->on('solicitacoes');
           $table->foreign('user_id')->references('id')->on('users');
           $table->foreign('acao_id')->references('id')->on('acoes');

       });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('historicos');
    }
}
