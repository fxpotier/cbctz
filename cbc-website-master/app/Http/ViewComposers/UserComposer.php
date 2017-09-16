<?php namespace CityByCitizen\Http\ViewComposers;
use CityByCitizen\Services\RightRegister;
use Illuminate\View\View;

/**
 * Created by PhpStorm.
 * User: Hinomi
 * Date: 27/05/2015
 * Time: 14:32
 */

class UserComposer {
	private $rightRegister;

	function __construct(RightRegister $rightRegister) {
		$this->rightRegister = $rightRegister;
	}

	public function compose(View $view) {
		$view->withRights($this->rightRegister);
	}
}