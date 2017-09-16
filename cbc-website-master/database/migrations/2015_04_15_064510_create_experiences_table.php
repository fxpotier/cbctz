<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExperiencesTable extends Migration {

	/**
	 * Run the migrations.
	 * @return void
	 */
	public function up() {
		Schema::create('experiences', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users');
			$table->integer('area_id')->unsigned();
			$table->foreign('area_id')->references('id')->on('areas');
			$table->integer('partner_id')->unsigned()->nullable()->references('id')->on('partners');
			$table->integer('cover_picture_id')->unsigned()->nullable()->references('id')->on('pictures');
			$table->integer('thumbnail_picture_id')->unsigned()->nullable()->references('id')->on('pictures');
			$table->integer('duration');
			$table->integer('min_persons');
			$table->integer('max_persons');
			$table->decimal('incurred_cost', 5, 2);
            $table->decimal('incurred_transportation_cost', 5, 2);
            $table->decimal('incurred_food_drink_cost', 5, 2);
            $table->decimal('incurred_ticket_cost', 5, 2);
            $table->decimal('incurred_other_cost', 5, 2);
			$table->decimal('incurred_cost_per_person', 5, 2);
            $table->decimal('incurred_transportation_cost_per_person', 5, 2);
            $table->decimal('incurred_food_drink_cost_per_person', 5, 2);
            $table->decimal('incurred_ticket_cost_per_person', 5, 2);
            $table->decimal('incurred_other_cost_per_person', 5, 2);
			$table->decimal('suggested_tip', 5, 2);
			$table->boolean('is_experience_per_person');
			$table->enum('state', ['creating', 'validating', 'online', 'offline']);
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 * @return void
	 */
	public function down() {
		Schema::drop('experiences');
	}
}