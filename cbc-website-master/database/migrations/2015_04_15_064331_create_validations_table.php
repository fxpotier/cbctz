<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateValidationsTable extends Migration {

	/**
	 * Run the migrations.
	 * @return void
	 */
	public function up() {
		Schema::create('validations', function(Blueprint $table) {
			$table->increments('id');
			$table->string('reference');
			$table->string('validator_field');
			$table->string('constraint');
		});
	}

	/**
	 * Reverse the migrations.
	 * @return void
	 */
	public function down() {
		Schema::drop('validations');
	}
}