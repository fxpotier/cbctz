<?php
/**
 * Created by PhpStorm.
 * User: Marc
 * Date: 13/07/2015
 * Time: 10:57
 */

namespace CityByCitizen\Http\Controllers;

use CityByCitizen\Http\Controllers\Controller;
use CityByCitizen\Services\LanguageManager;
use Illuminate\Support\Facades\Auth;

class LanguageController extends Controller {
	/**
	 * @var LanguageManager
	 */
	private $languageManager;

	function __construct(LanguageManager $languageManager) {
		$this->languageManager = $languageManager;
	}

	public function getFindByQuery($query) {
		return json_encode($this->languageManager->FindByQuery($query, Auth::user()->user->displayLanguage));
	}
}