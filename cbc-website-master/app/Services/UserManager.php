<?php
/**
 * Created by PhpStorm.
 * User: Romain
 * Date: 26/05/2015
 * Time: 10:53
 */

namespace CityByCitizen\Services;

use CityByCitizen\Account;
use CityByCitizen\Language;
use CityByCitizen\Picture;
use CityByCitizen\User;

class UserManager {

    function __construct(LocalizationService $localizationService) {
        $this->localizationService = $localizationService;
    }


    /**
     * @param $data
     * @return static
     */
    public function Create($data) {
        $user = User::create([
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'gender' => isset($data['gender'])?$data['gender']:null,
            'birthdate' => isset($data['birthdate'])?$data['birthdate']:null,
            'phone' => isset($data['phone'])?$data['phone']:null
        ]);
        return $user;
    }

    /**
     * @param User $user
     * @param Account $account
     */
    public function AddAccount(User $user, Account $account) {
        $user->account()->associate($account);
    }

	/**
	 * @param User $user
	 * @param Picture $picture
	 */
	public function AddProfilePicture(User $user, Picture $picture) {
		$user->profilePicture()->associate($picture);
	}

    /**
     * @param User $user
     * @param Picture $picture
     */
    public function AddCoverPicture(User $user, Picture $picture) {
        $user->coverPicture()->associate($picture);
    }

    /**
     * @param User $user
     * @param Language $language
     */
    public function AddLanguage(User $user, Language $language) {
        $user->languages()->save($language);
    }

    /**
     * @param User $user
     * @param Language $language
     */
    public function SetMainLanguage(User $user, Language $language) {
        $user->mainLanguage()->associate($language);
    }

    /**
     * @param User $user
     * @param Language $language
     */
    public function SetDisplayLanguage(User $user, Language $language) {
        $user->displayLanguage()->associate($language);
    }

    /**
     * @param $mail
     * @return User $user
     */
    public function GetByMail($mail) {
        return Account::where('mail', '=', $mail)->first()->user;
    }

	public function CheckCompleted(User $user) {

	}

}