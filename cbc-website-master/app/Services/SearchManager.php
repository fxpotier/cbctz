<?php
/**
 * Created by PhpStorm.
 * User: Romain
 * Date: 22/06/2015
 * Time: 15:26
 */

namespace CityByCitizen\Services;

use CityByCitizen\Search;

class SearchManager {
    /**
     * @param $data
     * @return Search
     */
    public function Create($data) {
            $search = Search::create([
                'input' => $data
            ]);
        return $search;
    }
}