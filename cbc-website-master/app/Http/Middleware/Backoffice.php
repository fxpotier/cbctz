<?php
/**
 * Created by PhpStorm.
 * User: Hinomi
 * Date: 27/05/2015
 * Time: 16:00
 */

namespace CityByCitizen\Http\Middleware;

use CityByCitizen\Services\RightRegister;
use Closure;

class Backoffice {

	/**
	 * @var RightRegister
	 */
	private $rightRegister;

	function __construct(RightRegister $rightRegister) {
		$this->rightRegister = $rightRegister;
	}

	public function handle($request, Closure $next) {
		if (!$this->rightRegister->can('use_back_office'))
			return response('Forbidden.', 403);

		return $next($request);
	}
}