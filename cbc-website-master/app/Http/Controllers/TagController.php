<?php
/**
 * Created by PhpStorm.
 * User: Kyappy
 * Date: 10/09/2015
 * Time: 09:41
 */

namespace CityByCitizen\Http\Controllers;


use CityByCitizen\Services\LocalizationService;
use CityByCitizen\Services\TagManager;
use Illuminate\Support\Facades\Auth;

class TagController extends Controller {
	/**
	 * @var TagManager
	 */
	private $tagManager;

	/**
	 * @var LocalizationService
	 */
	protected $localizationService;

	function __construct(TagManager $tagManager, LocalizationService $localizationService) {
		$this->tagManager = $tagManager;
		$this->localizationService = $localizationService;
	}

	public function getFindByQuery($query) {
		$query = str_slug($query);
		$language = Auth::check() ? Auth::user()->user->displayLanguage : $this->localizationService->GetLanguage();
		return json_encode($this->tagManager->FindByQuery($query, $language));
	}
}