<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoleRightTable extends Migration {

	/**
	 * Run the migrations.
	 * @return void
	 */
	public function up() {
		Schema::create('right_role', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('role_id')->unsigned()->nullable();
			$table->foreign('role_id')->references('id')->on('roles');
			$table->integer('right_id')->unsigned()->nullable();
			$table->foreign('right_id')->references('id')->on('rights');
		});
	}

	/**
	 * Reverse the migrations.
	 * @return void
	 */
	public function down() {
		Schema::drop('right_role');
	}

}
