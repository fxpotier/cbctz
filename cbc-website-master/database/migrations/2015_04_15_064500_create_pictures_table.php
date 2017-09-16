<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePicturesTable extends Migration {

	/**
	 * Run the migrations.
	 * @return void
	 */
	public function up() {
		Schema::create('pictures', function(Blueprint $table) {
			$table->increments('id');
			$table->morphs('picturable');
			$table->string('source');
			$table->string('source_thumbnail');
			$table->string('album');
		});
	}

	/**
	 * Reverse the migrations.
	 * @return void
	 */
	public function down() {
		Schema::drop('pictures');
	}
}