<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlugsTable extends Migration {

	/**
	 * Run the migrations.
	 * @return void
	 */
	public function up() {
		Schema::create('slugs', function(Blueprint $table) {
			$table->increments('id');
			$table->morphs('sluggable');
			$table->string('name');
			$table->unique( array('name','sluggable_type') );
			$table->string('reference');
		});
	}

	/**
	 * Reverse the migrations.
	 * @return void
	 */
	public function down() {
		Schema::drop('slugs');
	}
}