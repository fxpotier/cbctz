<?php
/**
 * Created by PhpStorm.
 * User: Hinomi
 * Date: 04/05/2015
 * Time: 18:55
 */

namespace CityByCitizen\Services;

use Carbon\Carbon;
use CityByCitizen\Account;
use CityByCitizen\FacebookAccount;
use CityByCitizen\Picture;
use CityByCitizen\Role;
use CityByCitizen\Token;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use ThunderArrow\Validation\Contracts\IValidationManager;
use ThunderArrow\Validation\Services\SuperValidator;

/**
 * Class AccountManager
 * @package CityByCitizen\Services
 */
class AccountManager {
	/**
	 * @var LocalizationService
	 */
	private $localizationService;
    private $userManager;

	function __construct(LocalizationService $localizationService, UserManager $userManager) {
		$this->localizationService = $localizationService;
        $this->userManager = $userManager;
	}

	//region Account creation
	/**
	 * @param $data
	 * @param Role $role
	 *
	 * @return Account
	 */
	public function Create($data, Role $role = null) {
		$accountData = ['mail' => $data['mail']];
		if (isset($data['password']))  $accountData['password'] = bcrypt($data['password']);

		$account = Account::create($accountData);

		if ($role == null) $role = Role::whereType('citizen')->first();
		$account->role()->associate($role);

        $data = array_intersect_key($data, array_flip(['firstname', 'lastname','birthdate','phone','gender']));

        $currentLanguage = $this->localizationService->GetLanguage();
        $user = $this->userManager->Create($data);
        $this->userManager->AddAccount($user, $account);
        $this->userManager->SetMainLanguage($user, $currentLanguage);
        $this->userManager->SetDisplayLanguage($user, $currentLanguage);
        $user->save();

		$this->AddLanguage($account, $currentLanguage);

		return $account;
	}

	/**
	 * @param Token $token
	 */
	public function SendActivationMail(Token $token, $name) {
		Mail::send('emails.activation', ['token' => $token->token,'name' => $name, 'url' => str_replace('/', '_', base64_encode(session('url.intended')))], function($mail) use($token, $name) {
			$mail->from(config('cbc.mail-notification'), config('cbc.name'))
				->to($token->account->mail)
				->subject(trans('fragment/auth/emails.activate.subject'));
		});
	}

	public function Activate(Account $account) {
		$account->activated = true;
        $account->role_id = true;
		$account->save();
		return $account;
	}

	public function CreateFacebookAccount($token, $longToken, $id, $accountData) {
		$account = $this->Create($accountData);
		$facebookAcount = new FacebookAccount();
		$facebookAcount->token = $token;
		$facebookAcount->long_token = $longToken;
		$facebookAcount->facebook_id = $id;
		$facebookAcount->account()->associate($account);
		$facebookAcount->save();
		$this->Activate($account);
		return $facebookAcount;
	}
	//endregion

	//region Log in process
	public function SendRecoverMail(Token $token) {
        $name = Account::where('mail', '=',$token->account->mail)->first()->user->firstname;
		Mail::send('emails.reset-password', ['token' => $token->token, 'name' => $name], function($mail) use($token) {
			$mail->from(config('cbc.mail-support'), config('cbc.name'))
				->to($token->account->mail)
				->subject(trans('fragment/auth/emails.reset.subject'));
		});
	}

	public function ResetPassword(Account $account, $data) {
		$validator = SuperValidator::make(['password' => 'required|confirmed'], $data);
		if ($validator->fails()) return $validator;

		$account->password = bcrypt($data['password']);
		$account->save();
		return true;
	}

	public function LogIn($mail, $password, $remember) {
		return Auth::attempt([
			'mail' => $mail,
			'password' => $password,
			'activated' => true
		], $remember);
	}
	//endregion

	//region User languages management
	public function AddLanguage(Account $account, $lang) {
		if($lang instanceof Collection) foreach($lang as $item) $this->AddLanguage($account, $item);
		else if (!$this->Speaks($account, $lang)) $account->user->languages()->save($lang);
	}

	public function Speaks($account, $lang) {
		return DB::table('language_user')->whereUserId($account->id)->whereLanguageId($lang->id)->first() != null;
	}

	public function UpdateLanguages(Account $account, $languages) {
		$user = $account->user;
		DB::table('language_user')->where('user_id', $user->id)->whereNotIn('language_id', $languages->lists('id'))->delete();
		$this->AddLanguage($account, $languages);
	}

	public function SetDisplayLanguage(Account $account, $lang) {
		$account->user->displayLanguage()->associate($lang)->save();
		$this->localizationService->SetLanguage($lang);
	}

	public function SetMainLanguage(Account $account, $lang) {
		$account->user->mainLanguage()->associate($lang)->save();
	}
	//endregion

	//region User pictures management
	public function AddPicture(Account $account, Picture $picture) {
		$account->user->pictures()->save($picture);
	}

	public function HasPicture(Account $account, $name) {
		$picture = Picture::whereSource($name)->ownedBy($account->user)->first();
		return $picture != null;
	}

	public function UpdateProfile(Account $account, $profile) {
		$user = $account->user;
		$user->firstname = $profile['firstname'];
		$user->lastname = $profile['lastname'];
		$user->gender = $profile['gender'];
		$user->phone = $profile['phone'];
		$user->nationality = $profile['nationality'];

		if ($profile['date']['year'] && $profile['date']['month'] && $profile['date']['day'])
			$user->birthdate = Carbon::createFromDate($profile['date']['year'], $profile['date']['month'], $profile['date']['day']);

		$user->save();
	}

	public function UpdateSettings(Account $account, $data) {
		$rules = [];

		if ($data['password'] != '') {
			if (!Hash::check($data['current_password'], $account->password))
				return new MessageBag(['current_password' => trans('user.profile.settings.bad_password')]);
			$rules['password'] = 'required|confirmed';
		}

		if ($account->mail != $data['mail']) $rules['mail'] = 'required|email|unique:accounts';

		$validator = SuperValidator::make($data, $rules);

		if ($validator->fails()) return $validator->messages();

		if ($account->mail != $data['mail']) $account->mail = $data['mail'];
		if ($data['password'] != '') $account->password = Hash::make($data['password']);
		$account->save();
		return null;
	}
	//endregion
}