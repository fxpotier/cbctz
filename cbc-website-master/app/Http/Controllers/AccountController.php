<?php
/**
 * Created by PhpStorm.
 * User: Hinomi
 * Date: 04/05/2015
 * Time: 15:44
 */

namespace CityByCitizen\Http\Controllers;


use CityByCitizen\Account;
use CityByCitizen\Language;
use CityByCitizen\Services\AccountManager;
use CityByCitizen\Services\LocalizationService;
use CityByCitizen\Services\SlugManager;
use CityByCitizen\Services\TokenManager;
use CityByCitizen\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use ThunderArrow\Validation\Services\SuperValidator;

class AccountController extends Controller {
	#region properties
	/**
	 * @var AccountManager
	 */
	private $accountManager;
	/**
	 * @var TokenManager
	 */
	private $tokenManager;
	/**
	 * @var SlugManager
	 */
	private $slugManager;
	#endregion

	/**
	 * @param AccountManager $accountManager
	 * @param TokenManager $tokenManager
	 * @param SlugManager $slugManager
	 */
	function __construct(AccountManager $accountManager, TokenManager $tokenManager, SlugManager $slugManager) {
		$this->accountManager = $accountManager;
		$this->tokenManager = $tokenManager;
		$this->slugManager = $slugManager;
	}

	#region Logging
	public function getSignIn() {
		return view('auth.sign-in');
	}

	public function postSignIn(Request $request) {
		if ($this->accountManager->LogIn($request->input('mail'), $request->input('password'), $request->has('remember')))
			return redirect()->intended();
		else return view('auth.sign-in')->withMail($request->input('mail'))->withError(trans('fragment/auth/signin.failed'));
	}

	public function getLogOut() {
		Auth::logout();
		return redirect('/');
	}
	#endregion

	#region Password
	public function getForgotPassword() {
		return view('auth.forgot-password');
	}

	public function postForgotPassword(Request $request) {
		$account = Account::whereMail($request->input('mail'))->first();
		if ($account == null) return view('auth.forgot-password')->withError(trans('fragment/auth/forgot.unknown'));

		$token = $this->tokenManager->CreateResetPassword($account);
		$this->accountManager->SendRecoverMail($token);
		return view('common.message')->withMessage(trans('fragment/auth/forgot.sent'))->withType('info');
	}

	public function getResetPassword($tokenId) {
		$token = $this->tokenManager->GetToken($tokenId, 'reset_password');
		if ($token == null) return view('common.message')->withMessage(trans('fragment/auth/reset.invalid'))->withType('danger');
		return view('auth.reset-password')->withToken($tokenId);
	}

	public function postResetPassword(Request $request, $tokenId) {
		$token = $this->tokenManager->GetToken($tokenId, 'reset_password');
		if ($token == null) return view('common.message')->withMessage(trans('fragment/auth/reset.invalid'))->withType('error');
		$token->delete();

		$reset = $this->accountManager->ResetPassword($token->account, $request->only('password', 'password_confirmation'));
		if ($reset === true) return view('common.message')->withMessage(trans('fragment/auth/reset.success'))->withType('success');
		return view('auth.reset-password')->withToken($tokenId)->withErrors($reset->errors());
	}
	#endregion

	#region	Signing up
	public function getSignUp() {
		return view('auth.sign-up');
	}

	public function postSignUp(Request $request) {
		$data = $request->only('firstname', 'lastname', 'mail', 'password', 'password_confirmation');
		$validate = SuperValidator::make('AccountCreation', $data);
		if ($validate->fails()) return view('auth.sign-up')->withErrors($validate->errors())->withInput($request->except('password', 'password_confirmation'));
		$account = $this->accountManager->Create($data);

		$user = $account->user;
		$slug = $this->slugManager->Create(['name' => $user->firstname . '-' . $user->lastname[0], 'type' => User::class]);
		$this->slugManager->AddSlug($slug, $user);

		$token = $this->tokenManager->CreateActivation($account);
		$this->accountManager->SendActivationMail($token, $user->firstname);
		return view('common.message')->withMessage(trans('fragment/auth/signup.success', ['mail' => $account->mail]))->withType('success');
	}

	public function getActivate($token,$url = null) {
        $url = base64_decode(str_replace('_', '/', $url));
		$token = $this->tokenManager->GetToken($token, 'activation');
		if ($token == null) return view('common.message')->withMessage(trans('fragment/auth/activation.invalid_token'))->withType('danger');

		$account = $token->account;
		if ($account->activated) return view('common.message')->withMessage(trans('fragment/auth/activation.activated'))->withType('danger');
		$this->accountManager->Activate($account);

        Auth::Login($account,true);
        return Redirect::action('ProfileController@getIndex');
		//return view('user.profile')->withMessage(trans('fragment/auth/activation.success'))->withType('success');
	}
	#endregion
}