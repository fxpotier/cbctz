<?php
/**
 * Created by PhpStorm.
 * User: Hinomi
 * Date: 04/08/2015
 * Time: 16:27
 */

namespace CityByCitizen\Events;


class FacebookTokenEvent extends Event {
	public $oldToken;
	public $newToken;

	/**
	 * FacebookTokenEvent constructor.
	 *
	 * @param $oldToken
	 * @param $newToken
	 */
	public function __construct($oldToken, $newToken) {
		$this->oldToken = $oldToken;
		$this->newToken = $newToken;
	}
}