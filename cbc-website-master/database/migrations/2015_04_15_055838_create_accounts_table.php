<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsTable extends Migration {

	/**
	 * Run the migrations.
	 * @return void
	 */
	public function up() {
		Schema::create('accounts', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->rememberToken();
			$table->string('mail');
			$table->string('password', 60);
			$table->boolean('activated');
			$table->boolean('blocked');
			$table->boolean('registered');
			$table->integer('role_id')->references('id')->on('roles');
		});
	}

	/**
	 * Reverse the migrations.
	 * @return void
	 */
	public function down() {
		Schema::drop('accounts');
	}
}