<?php
/**
 * Created by PhpStorm.
 * User: Marc
 * Date: 11/06/2015
 * Time: 15:18
 */

namespace CityByCitizen\Seeds;

use CityByCitizen\Address;
use CityByCitizen\Services\AddressManager;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class AddressesSeeder extends Seeder {
	#region attributes
	/**
	 * @var AddressManager
	 */
	private $addressManager;
	#endregion

	#region constructor
	function __construct (AddressManager $addressManager) {
		$this->addressManager = $addressManager;
	}
	#endregion

	/**
	 * @param $dataToSeed
	 * @return array|Address
	 */
	public function Create($dataToSeed) {
		if($dataToSeed instanceof Collection) {
			$addresses = [];
			foreach ($dataToSeed as $address) $addresses[] = $this->Create($address);
			return $addresses;
		}
		else return $this->addressManager->Create($dataToSeed);
	}
} 