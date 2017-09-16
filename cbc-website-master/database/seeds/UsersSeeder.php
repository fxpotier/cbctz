<?php
/**
 * Created by PhpStorm.
 * User: Hinomi
 * Date: 12/05/2015
 * Time: 17:43
 */

namespace CityByCitizen\Seeds;

use CityByCitizen\Account;
use CityByCitizen\Role;
use CityByCitizen\Services\AccountManager;
use CityByCitizen\Services\AddressManager;
use CityByCitizen\Services\LanguageManager;
use CityByCitizen\Services\SlugManager;
use CityByCitizen\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class UsersSeeder extends Seeder {
	#region attributes
	/**
	 * @var AccountManager
	 */
	private $accountManager;
	/**
	 * @var SlugManager
	 */
	private $slugManager;
	/**
	 * @var LanguageManager
	 */
	private $languageManager;
	/**
	 * @var AddressesSeeder
	 */
	private $addressesSeeder;
	/**
	 * @var SlugsSeeder
	 */
	private $slugsSeeder;
	#endregion

	#region constructor
	function __construct(AccountManager $accountManager, SlugManager $slugManager, AddressManager $addressManager, LanguageManager $languageManager) {
		$this->accountManager = $accountManager;
		$this->slugManager = $slugManager;
		$this->languageManager = $languageManager;
		$this->slugsSeeder = new SlugsSeeder($slugManager);
		$this->addressesSeeder = new AddressesSeeder($addressManager);
	}
	#endregion

	public function run() {
		$dataToSeed = include "data/users.php";
		$this->Create(collect($dataToSeed));
	}

	/**
	 * @param $dataToSeed
	 * @return array|Account
	 */
	public function Create($dataToSeed) {
		if($dataToSeed instanceof Collection) {
			$accounts = [];
			foreach ($dataToSeed as $account) $accounts[] = $this->Create($account);
			return $accounts;
		}
		else {
			$buildData = $this->buildData($dataToSeed);
			$account = $this->accountManager->Create($dataToSeed['data'], $dataToSeed['role'] ? Role::whereType($dataToSeed['role'])->first() : null);
			if ($dataToSeed['activate']) $this->accountManager->Activate($account);
			$this->associate($account, $buildData);
			return $account;
		}
	}

	private function buildData($eb) {
        $address = isset($eb['address']) ? $this->addressesSeeder->Create($eb['address']):null;
		return [
			'language_aliases' => $eb['language_aliases'],
			'slug' => $this->slugsSeeder->Create(['name' => $eb['data']['firstname'] . '-' . $eb['data']['lastname'][0], 'type' => 'CityByCitizen\User']),
            'address' => $address
		];
	}

	/**
	 * @param Account $account
	 * @param $buildData
	 */
	private function associate($account, $buildData) {
		$this->slugManager->AddSlug($buildData['slug'], $account->user);
		if($buildData['address']) $account->user->address()->save($buildData['address']);
		foreach ($buildData['language_aliases'] as $alias)
			$this->accountManager->AddLanguage($account, $this->languageManager->FindByAlias($alias));
	}
}