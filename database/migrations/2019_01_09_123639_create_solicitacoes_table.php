<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSolicitacoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitacoes', function(Blueprint $table) {
           $table->increments('id');

           $table->unsignedInteger('requerimento_id');
           $table->unsignedInteger('user_id');
           $table->string('status_atual');

           //Controle do laravel
           $table->timestampsTz();
           $table->softDeletes();

           //Chave estrangeira
            $table->foreign('requerimento_id')->references('id')->on('requerimentos');
            $table->foreign('user_id')->references('id')->on('users');
       });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('solicitacoes');
    }
}
