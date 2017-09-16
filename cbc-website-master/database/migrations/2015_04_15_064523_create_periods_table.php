<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeriodsTable extends Migration {

	/**
	 * Run the migrations.
	 * @return void
	 */
	public function up() {
		Schema::create('periods', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('experience_id')->unsigned();
			$table->foreign('experience_id')->references('id')->on('experiences');
			$table->date('start');
			$table->date('end');
			$table->enum('state', ['auto_accept', 'disabled']);
		});
	}

	/**
	 * Reverse the migrations.
	 * @return void
	 */
	public function down() {
		Schema::drop('periods');
	}
}