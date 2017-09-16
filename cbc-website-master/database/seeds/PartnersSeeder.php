<?php
/**
 * Created by PhpStorm.
 * User: Marc
 * Date: 11/06/2015
 * Time: 15:03
 */

namespace CityByCitizen\Seeds;

use CityByCitizen\Partner;
use CityByCitizen\Services\PartnerManager;
use CityByCitizen\Services\PictureManager;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class PartnersSeeder extends Seeder {
	#region attributes
	/**
	 * @var PartnerManager
	 */
	private $partnerManager;
	/**
	 * @var PictureManager
	 */
	private $pictureManager;
	#endregion

	#region constructor
	function __construct (PartnerManager $partnerManager, PictureManager $pictureManager) {
		$this->partnerManager = $partnerManager;
		$this->pictureManager = $pictureManager;
	}
	#endregion

	/**
	 * @param $dataToSeed
	 * @return array|Partner
	 */
	public function Create($dataToSeed) {
		if($dataToSeed instanceof Collection) {
			$partners = [];
			foreach($dataToSeed as $partner) $partners[] = $this->Create($partner);
			return $partners;
		}
		else {
			$partner = $this->partnerManager->Create($dataToSeed['data']);
			$this->partnerManager->AddPicture($partner, $this->pictureManager->Create($dataToSeed['picture']));
			$partner->save();
			return $partner;
		}
	}
} 