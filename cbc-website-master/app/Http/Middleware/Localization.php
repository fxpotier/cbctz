<?php
/**
 * Created by PhpStorm.
 * User: Hinomi
 * Date: 28/05/2015
 * Time: 16:53
 */

namespace CityByCitizen\Http\Middleware;


use CityByCitizen\Services\LocalizationService;
use Closure;
use Illuminate\Support\Facades\Auth;

class Localization {

	function __construct(LocalizationService $localizationService) {
		$localizationService->SetLanguage(Auth::check() ? Auth::user()->user->displayLanguage : null);
	}

	public function handle($request, Closure $next) {
		return $next($request);
	}
}