<?php
/**
 * Created by PhpStorm.
 * User: Hinomi
 * Date: 04/08/2015
 * Time: 16:19
 */

namespace CityByCitizen\Services;

use CityByCitizen\Events\FacebookTokenEvent;
use CityByCitizen\FacebookAccount;
use ThunderArrow\Rest\RestRequest;

define('FACEBOOK_HOST', 'https://graph.facebook.com/v2.4');

define('FACEBOOK_OAUTH',FACEBOOK_HOST.'/oauth');
define('FACEBOOK_ACCESS_TOKEN',FACEBOOK_OAUTH.'/access_token');
define('FACEBOOK_CLIENT_CODE',FACEBOOK_OAUTH.'/client_code');

define('FACEBOOK_USER', FACEBOOK_HOST.'/{user-id}');

class FacebookService {
	private $token;

	/**
	 * FacebookService constructor.
	 *
	 * @param null $token
	 */
	public function __construct($token = null) {
		$this->token = $token;
	}

	public function signup($code, $uri) {
		$req = RestRequest::get(FACEBOOK_ACCESS_TOKEN);
		$req->setQueryParameter('client_id', config('social.facebook.client_id'));
		$req->setQueryParameter('client_secret', config('social.facebook.client_secret'));
		$req->setQueryParameter('code', $code);
		$req->setQueryParameter('redirect_uri', $uri);
		$res = $req->send();

		if ($res->status != 200) throw new \Exception($res->body->error->message);
		$this->setToken($res->body->access_token);
		return FacebookAccount::where('token', $res->body->access_token)->first();
	}

	public function getLongLivedToken($uri) {
		$req = RestRequest::get(FACEBOOK_CLIENT_CODE);
		$req->setQueryParameter('client_id', config('social.facebook.client_id'));
		$req->setQueryParameter('client_secret', config('social.facebook.client_secret'));
		$req->setQueryParameter('redirect_uri', $uri);

		return $this->execute($req)->code;
	}

	public function getProfile($fields = null, $id = 'me') {
		$req = RestRequest::get(FACEBOOK_USER);
		$req->templateUrl('user-id', $id);
		if ($fields !== null) $req->setQueryParameter('fields', implode(',', $fields));
		return $this->execute($req);
	}

	private function setToken($token) {
		event(new FacebookTokenEvent($this->token, $token));
		$this->token = $token;
	}

	private function execute(RestRequest $request) {
		$request->setQueryParameter('access_token', $this->token);
		$res = $request->send();

		if ($res->status != 200) {
			dd($res->body);
			throw new \Exception($res->body->error->message);
		}

		return $res->body;
	}
}