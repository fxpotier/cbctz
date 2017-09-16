<?php
/**
 * Created by PhpStorm.
 * User: Marc
 * Date: 15/06/2015
 * Time: 11:53
 */

namespace CityByCitizen\Http\Controllers;


class ArticleController extends Controller {
	public function getIndex() {
		return view('user.article');
	}
} 