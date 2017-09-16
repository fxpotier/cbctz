<?php
/**
 * Created by PhpStorm.
 * User: Romain
 * Date: 21/05/2015
 * Time: 12:38
 */

namespace CityByCitizen\Services;

use CityByCitizen\Area;

class AreaManager {
	/**
	 * @param $range
	 * @return Area
	 */
	public function Create($range) {
        $area = Area::create([
            'range' => $range
        ]);
        return $area;
    }
}