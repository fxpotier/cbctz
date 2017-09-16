<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLanguageUserTable extends Migration {

	/**
	 * Run the migrations.
	 * @return void
	 */
	public function up() {
		Schema::create('language_user', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('language_id')->unsigned()->nullable();
			$table->foreign('language_id')->references('id')->on('languages');
			$table->integer('user_id')->unsigned()->nullable();
			$table->foreign('user_id')->references('id')->on('users');
			$table->unique(['user_id', 'language_id']);
		});
	}

	/**
	 * Reverse the migrations.
	 * @return void
	 */
	public function down() {
		Schema::drop('language_user');
	}
}