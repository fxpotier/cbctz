<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 * @return void
	 */
	public function run() {
		Model::unguard();

        $this->call('ClearAllSeeder');
        $this->call('CityByCitizen\Seeds\RolesSeeder');
		$this->call('CityByCitizen\Seeds\LanguagesTableSeeder');
		$this->call('CityByCitizen\Seeds\UsersSeeder');
        $this->call('CityByCitizen\Seeds\ExperiencesSeeder');
        $this->call('CityByCitizen\Seeds\EventsSeeder');

	}
}
