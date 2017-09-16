<?php
/**
 * Created by PhpStorm.
 * User: Marc
 * Date: 15/06/2015
 * Time: 11:50
 */

namespace CityByCitizen\Http\Controllers;

class AnalyticController extends Controller {
	public function getIndex() {
		return view('user.analytic');
	}
} 