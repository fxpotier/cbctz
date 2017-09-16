<?php
/**
 * Created by PhpStorm.
 * User: Marc
 * Date: 11/06/2015
 * Time: 15:42
 */

namespace CityByCitizen\Seeds;

use CityByCitizen\Picture;
use CityByCitizen\Services\PictureManager;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class PicturesSeeder extends Seeder {
	#region attributes
	/**
	 * @var PictureManager
	 */
	private $pictureManager;
	#endregion

	#region constructor
	function __construct (PictureManager $pictureManager) {
		$this->pictureManager = $pictureManager;
	}
	#endregion

	/**
	 * @param $dataToSeed
	 * @return array|Picture
	 */
	public function Create($dataToSeed) {
		if($dataToSeed instanceof Collection) {
			$pictures = [];
			foreach ($dataToSeed as $picture) $pictures[] = $this->Create($picture);
			return $pictures;
		}
		else return $this->pictureManager->Create($dataToSeed);
	}
}