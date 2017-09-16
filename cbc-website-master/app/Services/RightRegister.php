<?php
/**
 * Created by PhpStorm.
 * User: Hinomi
 * Date: 27/05/2015
 * Time: 14:28
 */

namespace CityByCitizen\Services;

use Illuminate\Support\Facades\Auth;

class RightRegister {
	private $rights = [];

	function __construct() {
		if (!Auth::check()) return;

		$rights = Auth::user()->role->rights;
		foreach ($rights as $right)
			$this->rights[] = $right->name;
	}

	public function can($right) {
		return in_array($right, $this->rights);
	}
}