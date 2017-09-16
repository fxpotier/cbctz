<?php
/**
 * Created by PhpStorm.
 * User: Marc
 * Date: 11/06/2015
 * Time: 15:09
 */

namespace CityByCitizen\Seeds;

use CityByCitizen\Services\SlugManager;
use CityByCitizen\Slug;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class SlugsSeeder extends Seeder {
	#region attributes
	/**
	 * @var SlugManager
	 */
	private $slugManager;
	#endregion

	#region constructor
	function __construct (SlugManager $slugManager) {
		$this->slugManager = $slugManager;
	}
	#endregion

	/**
	 * @param $dataToSeed
	 * @return array|Slug
	 */
	public function Create($dataToSeed) {
		if($dataToSeed instanceof Collection) {
			$slugs = [];
			foreach ($dataToSeed as $slug) {
				if($slug['lang']) $slugs[$slug['lang']] = $this->Create($slug['data']);
				else $slugs[] = $this->Create($slug['data']);
			}
			return $slugs;
		}
		else return $this->slugManager->Create($dataToSeed);
	}
}