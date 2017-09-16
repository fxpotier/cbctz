<?php
/**
 * Created by PhpStorm.
 * User: Marc
 * Date: 11/06/2015
 * Time: 15:25
 */

namespace CityByCitizen\Seeds;

use CityByCitizen\Area;
use CityByCitizen\Services\AddressManager;
use CityByCitizen\Services\AreaManager;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class AreasSeeder extends Seeder {
	#region attributes
	/**
	 * @var AreaManager
	 */
	private $areaManager;
	/**
	 * @var AddressManager
	 */
	private $addressManager;
	#endregion

	#region constructor
	function __construct (AreaManager $areaManager, AddressManager $addressManager) {
		$this->areaManager = $areaManager;
		$this->addressManager = $addressManager;
	}
	#endregion

	/**
	 * @param $dataToSeed
	 * @return array|Area
	 */
	public function Create($dataToSeed) {
		if($dataToSeed instanceof Collection) {
			$areas = [];
			foreach ($dataToSeed as $area) $areas[] = $this->Create($area);
			return $areas;
		}
		else {
			$address = $this->addressManager->Create($dataToSeed['address']);
			$area = $this->areaManager->Create($dataToSeed['data']['range']);
			$this->addressManager->AddAddress($address, $area);
			return $area;
		}
	}
} 