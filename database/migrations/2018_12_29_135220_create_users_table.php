<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateUsersTable.
 */
class CreateUsersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table) {
           $table->increments('id');

            $table->string('name', 255);
            $table->string('email',80)->unique();
            $table->string('username', 80)->unique();
            $table->char('matricula',20)->nullable();
            $table->char('cpf', 11)->unique();
            $table->string('password',60);
            $table->string('status')->default('ativo');

            $table->rememberToken();
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
		Schema::drop('users');
	}
}
