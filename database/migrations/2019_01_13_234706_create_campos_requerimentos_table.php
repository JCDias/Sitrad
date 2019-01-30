<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCamposRequerimentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('campos_requerimentos', function(Blueprint $table) {
       $table->increments('id');

       $table->unsignedInteger('requerimento_id');
       $table->unsignedInteger('campo_id');
       $table->string('name',191);
       $table->string('label',191);
       $table->string('placeholder',191);
       $table->integer('tamanho');
       $table->integer('ordem');
       $table->string('mascara',191)->nullable();


           //Controle do laravel
       $table->timestampsTz();
       $table->softDeletes();

           //Chave estrangeira
       $table->foreign('requerimento_id')->references('id')->on('requerimentos');
       $table->foreign('campo_id')->references('id')->on('campos');

     });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::drop('campos_requerimentos');
    }
  }
