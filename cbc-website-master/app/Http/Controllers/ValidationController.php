<?php
/**
 * Created by PhpStorm.
 * User: Hinomi
 * Date: 27/05/2015
 * Time: 15:58
 */

namespace CityByCitizen\Http\Controllers;


use CityByCitizen\Services\LocalizationService;
use CityByCitizen\Services\ValidationService;
use Illuminate\Http\Request;

class ValidationController extends Controller {
	/**
	 * @var ValidationService
	 */
	private $validationService;

	function __construct(ValidationService $validationService) {
		$this->middleware('backoffice');
		$this->validationService = $validationService;
	}

	public function getIndex() {
		return view('backoffice.validation')->withList($this->validationService->rulesList());
	}

	public function getRules($name) {
		return $this->validationService->getRules($name);
	}

	public function postSave(Request $request, $name) {
		$this->validationService->save($name, $request->all());
	}
}