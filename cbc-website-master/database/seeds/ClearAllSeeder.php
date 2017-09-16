<?php
/**
 * Created by PhpStorm.
 * User: Hinomi
 * Date: 29/05/2015
 * Time: 11:59
 */

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClearAllSeeder extends Seeder {
	public function run() {
		DB::table('periods')->delete();
		DB::table('travels')->delete();
		DB::table('events')->delete();
		DB::table('experience_language')->delete();
		DB::table('experiences')->delete();
		DB::table('addresses')->delete();
		DB::table('areas')->delete();
		DB::table('descriptions')->delete();
		DB::table('language_user')->delete();
		DB::table('translations')->delete();
		DB::table('languages')->delete();
		DB::table('partners')->delete();
		DB::table('pictures')->delete();
		DB::table('right_role')->delete();
		DB::table('roles')->delete();
		DB::table('rights')->delete();
		DB::table('feedbacks')->delete();
		DB::table('feedback_stats')->delete();
		DB::table('accounts')->delete();
		DB::table('users')->delete();
		DB::table('slugs')->delete();
		DB::table('payments')->delete();
	}
}