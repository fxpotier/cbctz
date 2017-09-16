<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 * @return void
	 */
	public function up() {
		Schema::create('users', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('account_id')->unsigned()->nullable()->references('id')->on('accounts');
			$table->string('firstname')->nullable();
			$table->string('lastname')->nullable();
			$table->integer('cover_picture_id')->unsigned()->nullable()->references('id')->on('pictures');
			$table->integer('profile_picture_id')->unsigned()->nullable()->references('id')->on('pictures');
			$table->string('phone')->nullable();
			$table->string('gender')->nullable();
			$table->string('nationality')->nullable();
			$table->date('birthdate')->nullable();
			$table->integer('main_language_id')->unsigned()->nullable()->references('id')->on('languages');
			$table->integer('display_language_id')->unsigned()->nullable()->references('id')->on('languages');

		});
	}

	/**
	 * Reverse the migrations.
	 * @return void
	 */
	public function down() {
		Schema::drop('users');
	}
}