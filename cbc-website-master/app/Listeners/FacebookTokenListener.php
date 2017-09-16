<?php namespace CityByCitizen\Listeners;
use CityByCitizen\Events\FacebookTokenEvent;
use CityByCitizen\FacebookAccount;
use CityByCitizen\Services\AccountManager;
use CityByCitizen\Services\FacebookService;
use Illuminate\Support\Facades\Log;

/**
 * Created by PhpStorm.
 * User: Hinomi
 * Date: 04/08/2015
 * Time: 16:28
 */
class FacebookTokenListener {
	/**
	 * @var AccountManager
	 */
	private $accountManager;

	/**
	 * FacebookTokenListener constructor.
	 *
	 * @param AccountManager $accountManager
	 */
	public function __construct(AccountManager $accountManager) {
		$this->accountManager = $accountManager;
	}

	public function handle(FacebookTokenEvent $event) {
		if ($event->oldToken == null) {
			$facebook = new FacebookService($event->newToken);
			$longLived = $facebook->getLongLivedToken(action('FacebookController@getSignup'));
			$profile = $facebook->getProfile(['first_name', 'last_name', 'email']);

			$account = FacebookAccount::where('facebook_id', $profile->id)->first();
			if ($account == null) {
				$account = $this->accountManager->CreateFacebookAccount($event->newToken, $longLived, $profile->id, [
					'firstname' => $profile->first_name,
					'lastname' => $profile->last_name,
					'mail' => $profile->email
				]);
			} else {
				$account->token = $event->newToken;
				$account->long_token = $longLived;
				$account->save();
			}
		}
	}
}