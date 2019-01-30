<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Tabela regras
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name', 50);
            $table->string('label', 200);

            $table->timestampsTz();
            $table->softDeletes();
        });

        //Tabela de regras do usuário
        Schema::create('role_user', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('role_id');
            $table->unsignedInteger('user_id');

            $table->timestampsTz();
            $table->softDeletes();

            //Chave estrangeira
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
        Schema::dropIfExists('role_user');
    }
}
