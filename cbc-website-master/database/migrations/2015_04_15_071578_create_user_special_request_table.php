<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserSpecialRequestTable extends Migration {

	/**
	 * Run the migrations.
	 * @return void
	 */
	public function up() {
		Schema::create('special_request_user', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id')->unsigned()->nullable();
			$table->foreign('user_id')->references('id')->on('users');
			$table->integer('special_request_id')->unsigned()->nullable();
			$table->foreign('special_request_id')->references('id')->on('special_requests');
		});
	}

	/**
	 * Reverse the migrations.
	 * @return void
	 */
	public function down() {
		Schema::drop('special_request_user');
	}
}