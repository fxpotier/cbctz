<?php
/**
 * Created by PhpStorm.
 * User: Hinomi
 * Date: 18/05/2015
 * Time: 16:25
 */

namespace CityByCitizen\Http\Controllers;


use CityByCitizen\Services\PictureManager;
use Illuminate\Support\Facades\Response;

class PicturesController extends Controller {

	function __construct() {
		$this->middleware('auth');
	}

	public function getIndex(PictureManager $pictureManager, $name) {
		$picture = $pictureManager->LoadPicture($name);
		if ($picture == null) return Response::make(trans('resources.404'), 404);
		return Response::make($picture->content, 200, [
			'Content-Type' => $picture->mime
		]);
	}
}