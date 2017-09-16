<?php
/**
 * Created by PhpStorm.
 * User: Hinomi
 * Date: 04/08/2015
 * Time: 19:14
 */

namespace CityByCitizen;


use Illuminate\Database\Eloquent\Model;

class FacebookAccount extends Model {
	public $timestamps = false;

	public function account() {
		return $this->belongsTo(Account::class);
	}
}