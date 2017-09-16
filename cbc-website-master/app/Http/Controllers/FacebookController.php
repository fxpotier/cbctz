<?php
/**
 * Created by PhpStorm.
 * User: Hinomi
 * Date: 04/08/2015
 * Time: 15:56
 */

namespace CityByCitizen\Http\Controllers;

use CityByCitizen\Services\FacebookService;
use Illuminate\Http\Request;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Facades\Auth;

class FacebookController extends Controller {
	public function getSignup(Request $request, FacebookService $facebook) {
		if ($request->has('error')) {
			echo $request->get('error_description');
			return;
		}

		$state = $request->get('state', null);
		if ($state != $request->session()->token())
			throw new TokenMismatchException;

		try {
			$account = $facebook->signup($request->get('code'), action('FacebookController@getSignup'));
			Auth::login($account->account, true);
		} catch (\Exception $e) {
			echo $e->getMessage();
		}
	}
}