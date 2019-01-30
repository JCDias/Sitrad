<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequerimentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requerimentos', function(Blueprint $table) {
           
           $table->increments('id');

           $table->unsignedInteger('tipo_id');
           $table->unsignedInteger('user_id');
           $table->string('table_name');
           $table->string('status');
           $table->text('passos');
           $table->text('informacoes')->nullable();

           //Controle do laravel
           $table->timestampsTz();
           $table->softDeletes();

           //Chave estrangeira
            $table->foreign('tipo_id')->references('id')->on('tipos');
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
        Schema::drop('requerimentos');
    }
}
