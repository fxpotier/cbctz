<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedbackStatsTable extends Migration {

	/**
	 * Run the migrations.
	 * @return void
	 */
	public function up() {
		Schema::create('feedback_stats', function(Blueprint $table) {
			$table->increments('id');
			$table->morphs('feedbackable');
            $table->decimal('rate_average',3,2);
			$table->integer('rate_count');
		});
	}

	/**
	 * Reverse the migrations.
	 * @return void
	 */
	public function down() {
		Schema::drop('feedback_stats');
	}
}
