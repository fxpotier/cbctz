<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSessionStartsTable extends Migration {

	/**
	 * Run the migrations.
	 * @return void
	 */
	public function up() {
		Schema::create('session_starts', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('period_id')->unsigned()->nullable();
			$table->foreign('period_id')->references('id')->on('periods');
			$table->dateTime('start_time');
		});
	}

	/**
	 * Reverse the migrations.
	 * @return void
	 */
	public function down() {
		Schema::drop('session_starts');
	}
}