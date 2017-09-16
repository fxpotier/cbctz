<?php namespace CityByCitizen\Http\Controllers;

use CityByCitizen\Services\LocalizationService;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Auth;

abstract class Controller extends BaseController {

	use DispatchesCommands, ValidatesRequests;

	/**
	 * @var LocalizationService
	 */
	protected $localizationService;

	function __construct(LocalizationService $localizationService) {
		//$localizationService->SetLanguage(Auth::check() ? Auth::user()->user->displayLanguage : null);
		$this->localizationService = $localizationService;
	}
}
