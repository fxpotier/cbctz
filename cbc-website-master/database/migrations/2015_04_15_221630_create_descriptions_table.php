<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDescriptionsTable extends Migration {

	/**
	 * Run the migrations.
	 * @return void
	 */
	public function up() {
		Schema::create('descriptions', function(Blueprint $table) {
			$table->increments('id');
			$table->morphs('describable');
			$table->string('title')->nullable();
			$table->text('content');
		});
	}

	/**
	 * Reverse the migrations.
	 * @return void
	 */
	public function down() {
		Schema::drop('descriptions');
	}
}