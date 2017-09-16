<?php
/**
 * Created by PhpStorm.
 * User: Marc
 * Date: 11/06/2015
 * Time: 15:15
 */

namespace CityByCitizen\Seeds;

use CityByCitizen\Description;
use CityByCitizen\Services\DescriptionManager;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class DescriptionsSeeder extends Seeder {
	#region attributes
	/**
	 * @var DescriptionManager
	 */
	private $descriptionManager;
	#endregion

	#region constructor
	function __construct (DescriptionManager $descriptionManager) {
		$this->descriptionManager = $descriptionManager;
	}
	#endregion

	/**
	 * @param $dataToSeed
	 * @return array|Description
	 */
	public function Create($dataToSeed) {
		if($dataToSeed instanceof Collection) {
			$descriptions = [];
			foreach ($dataToSeed as $description) {
				if($description['lang'])$descriptions[$description['lang']] = $this->Create($description['data']);
				else $descriptions[] = $this->Create($description['data']);
			}
			return $descriptions;
		}
		else return $this->descriptionManager->Create($dataToSeed);
	}
} 