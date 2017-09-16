<?php
/**
 * Created by PhpStorm.
 * User: Hinomi
 * Date: 05/05/2015
 * Time: 01:50
 */

namespace CityByCitizen\Services;

use Carbon\Carbon;
use CityByCitizen\Account;
use CityByCitizen\Token;

class TokenManager {
	public function ClearExpired() {
		Token::where('expiration_date', '<=', Carbon::now())->delete();
	}

	public function GetToken($token, $type) {
		$token = Token::valid()->byType($type)->whereToken($token)->first();
		if ($token != null && $type == 'activation') $token->delete();
		return $token;
	}

	public function CreateActivation(Account $account) {
		return $this->CreateToken($account, 'activation', Carbon::now()->addWeek());
	}

	public function CreateResetPassword(Account $account) {
		return $this->CreateToken($account, 'reset_password', Carbon::now()->addHour());
	}

	private function CreateToken(Account $account, $type, $date) {
		$token = Token::byType($type)->ownedBy($account)->first();
		if ($token == null) {
			$token = new Token();
			$token->type = $type;
			$token->account()->associate($account);
		}

		$token->token = str_random(40);
		$token->expiration_date = $date;
		$token->save();
		return $token;
	}
}