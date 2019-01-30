<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->string('label', 200);
            
            $table->timestampsTz();
            $table->softDeletes();
        });

         //Tabela de permissões do usuário
        Schema::create('permission_role', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('permission_id');
            $table->unsignedInteger('role_id');

            $table->timestampsTz();
            $table->softDeletes();

            //Chave estrangeira
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permission_role');
        Schema::dropIfExists('permissions');
    }
}
