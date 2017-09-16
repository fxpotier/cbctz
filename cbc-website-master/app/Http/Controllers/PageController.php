<?php
/**
 * Created by PhpStorm.
 * User: Marc
 * Date: 08/08/2015
 * Time: 03:24
 */

namespace CityByCitizen\Http\Controllers;

class PageController extends Controller {
	public function getAbout() {
		return view('page.about');
	}

	public function getFaq($type = null) {
		return view('page.faq')->withType($type);
	}

	public function getTerms() {
		return view('page.terms');
	}

	public function getPress() {
		return view('page.press');
	}
}