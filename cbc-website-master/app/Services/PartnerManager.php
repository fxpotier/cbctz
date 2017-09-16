<?php
/**
 * Created by PhpStorm.
 * User: Marc
 * Date: 22/05/2015
 * Time: 15:12
 */

namespace CityByCitizen\Services;

use CityByCitizen\Partner;
use CityByCitizen\Picture;

class PartnerManager {
	/**
	 * @param $data
	 * @return Partner
	 */
	public function Create($data) {
		$partner = new Partner([
			'name' => $data['name'],
			'link' => $data['link']
		]);
		return $partner;
	}

	/**
	 * @param Partner $partner
	 * @param Picture $picture
	 */
	public function AddPicture(Partner $partner, Picture $picture) {
		$partner->picture()->associate($picture);
	}
} 