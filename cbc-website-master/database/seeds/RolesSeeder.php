<?php
/**
 * Created by PhpStorm.
 * User: Hinomi
 * Date: 27/05/2015
 * Time: 13:09
 */

namespace CityByCitizen\Seeds;

use CityByCitizen\Right;
use CityByCitizen\Role;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder{
	public function run() {
		$this->populateRights();
		$this->populateRoles();
	}

	private function populateRoles() {
		$this->createRole('citizen');
		$this->createRole('admin', ['use_back_office']);
	}

	private function populateRights() {
		$this->createRight('use_back_office', 'This right gives access to the back office to the user');
	}

	private function createRight($name, $description) {
		return Right::create(['name' => $name, 'description' => $description]);
	}

	private function createRole($type, $rights = []) {
		foreach ($rights as $i => $name) {
			$rights[$i] = $right = Right::whereName($name)->first();
			if ($rights[$i] == null) unset($rights[$i]);
		}

		$role = Role::create(['type' => $type]);
		$role->rights()->saveMany($rights);
	}
}