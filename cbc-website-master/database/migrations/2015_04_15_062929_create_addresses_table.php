<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration {

	/**
	 * Run the migrations.
	 * @return void
	 */
	public function up() {
		Schema::create('addresses', function(Blueprint $table) {
			$table->increments('id');
			$table->morphs('addressable');
			$table->string('street')->nullable();
			$table->string('city');
			$table->char('zipcode', 5);
			$table->string('country');
			$table->integer('timezone')->nullable();
			$table->decimal('latitude', 10, 5)->nullable();
			$table->decimal('longitude', 10, 5)->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 * @return void
	 */
	public function down() {
		Schema::drop('addresses');
	}
}