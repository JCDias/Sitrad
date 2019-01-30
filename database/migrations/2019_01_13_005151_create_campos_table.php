<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCamposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campos', function(Blueprint $table) {
         $table->increments('id');

         $table->string('name',191);
         $table->string('tipo',191);

           //Controle do laravel
         $table->timestampsTz();
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
        Schema::drop('campos');
    }
}
