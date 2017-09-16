<?php
/**
 * Created by PhpStorm.
 * User: Hinomi
 * Date: 12/05/2015
 * Time: 17:43
 */

namespace CityByCitizen\Seeds;

use CityByCitizen\Experience;
use CityByCitizen\Services\AccountManager;
use CityByCitizen\Services\AddressManager;
use CityByCitizen\Services\AreaManager;
use CityByCitizen\Services\DescriptionManager;
use CityByCitizen\Services\EventManager;
use CityByCitizen\Services\ExperienceManager;
use CityByCitizen\Services\LanguageManager;
use CityByCitizen\Services\PartnerManager;
use CityByCitizen\Services\PictureManager;
use CityByCitizen\Services\FeedbackManager;
use CityByCitizen\Services\SlugManager;
use CityByCitizen\Services\TagManager;
use CityByCitizen\Services\TranslationManager;
use CityByCitizen\Services\UserManager;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class ExperiencesSeeder extends Seeder {
	#region attributes
	/**
	 * @var ExperienceManager
	 */
	private $experienceManager;
	/**
	 * @var AddressManager
	 */
	private $addressManager;
	/**
	 * @var DescriptionManager
	 */
	private $descriptionManager;
	/**
	 * @var SlugManager
	 */
	private $slugManager;
	/**
	 * @var LanguageManager
	 */
	private $languageManager;
	/**
	 * @var FeedbackManager
	 */
	private $rateManager;
	/**
	 * @var TagManager
	 */
	private $tagManager;
	/**
	 * @var TagsSeeder
	 */
	private $tagsSeeder;
	/**
	 * @var RatesSeeder
	 */
	private $ratesSeeder;
	/**
	 * @var PartnersSeeder
	 */
	private $partnersSeeder;
	/**
	 * @var SlugsSeeder
	 */
	private $slugsSeeder;
	/**
	 * @var AddressesSeeder
	 */
	private $addressesSeeder;
	/**
	 * @var AreasSeeder
	 */
	private $areasSeeder;
	/**
	 * @var TranslationsSeeder
	 */
	private $translationsSeeder;
	/**
	 * @var PicturesSeeder
	 */
	private $picturesSeeder;
    /**
     * @var UserManager
     */
    private $userManager;
    #endregion

	#region constructor
	function __construct (
		ExperienceManager $experienceManager, AreaManager $areaManager, AddressManager $addressManager,
		PictureManager $pictureManager, DescriptionManager $descriptionManager, PartnerManager $partnerManager,
		TranslationManager $translationManager, SlugManager $slugManager, LanguageManager $languageManager,
        FeedbackManager $rateManager, TagManager $tagManager, AccountManager $accountManager, UserManager $userManager) {

		$this->experienceManager = $experienceManager;
		$this->addressManager = $addressManager;
		$this->descriptionManager = $descriptionManager;
		$this->slugManager = $slugManager;
		$this->languageManager = $languageManager;
		$this->rateManager = $rateManager;
		$this->tagManager = $tagManager;
        $this->userManager = $userManager;

		$this->tagsSeeder = new TagsSeeder($tagManager, $translationManager);
		$this->descriptionsSeeder = new DescriptionsSeeder($descriptionManager);
		//$this->feedbackSeeder = new RatesSeeder($rateManager, $accountManager, $slugManager, $addressManager, $languageManager, $userManager);
		$this->partnersSeeder = new PartnersSeeder($partnerManager, $pictureManager);
		$this->slugsSeeder = new SlugsSeeder($slugManager);
		$this->addressesSeeder = new AddressesSeeder($addressManager);
		$this->areasSeeder = new AreasSeeder($areaManager, $addressManager);
		$this->translationsSeeder = new TranslationsSeeder($translationManager);
		$this->picturesSeeder = new PicturesSeeder($pictureManager);

    }
	#endregion

	public function run() {
		$dataToSeed = include 'data/experiences.php';
		$this->Create(collect($dataToSeed));
	}

	/**
	 * @param $dataToSeed
	 * @return array|Experience
	 */
	public function Create($dataToSeed) {
		if($dataToSeed instanceof Collection) {
			$experiences = [];
			foreach ($dataToSeed as $experience) $experiences[] = $this->Create($experience);
			return $experiences;
		}
		else {
			$buildData = $this->buildData($dataToSeed);
			$experience = $this->experienceManager->Create($dataToSeed['data']);
			$this->associate($experience, $buildData);
			return $experience;
		}
	}

	/**
	 * @param $eb
	 * @return array
	 */
	private function buildData($eb) {
		return [
			'language_aliases' => $eb['language_aliases'],
			'area' => $this->areasSeeder->Create($eb['area']),
			'meetingPoint' => $this->addressesSeeder->Create($eb['meetingPoint']),
			// 'coverPicture' => $this->picturesSeeder->Create($eb['cover']),
			'citizen' => $this->userManager->GetByMail($eb['userMail']),
			'descriptions' => $this->descriptionsSeeder->Create(collect($eb['descriptions'])),
			'slugs' => $this->slugsSeeder->Create(collect($this->slugsFromDescriptions($eb['descriptions']))),
			// 'partners' => $this->partnersSeeder->Create(collect($eb['partners'])),
			//'rates' => $this->ratesSeeder->Create(collect($eb['rates'])),
			'tags' => $this->tagsSeeder->Create(collect($eb['tags']))
		];
	}

	/**
	 * @param Experience $experience
	 * @param $buildData
	 */
	private function associate($experience, $buildData) {
		$this->experienceManager->AddArea($experience, $buildData['area']);
		// $this->experienceManager->AddPicture($experience, $buildData['coverPicture']);
		$this->experienceManager->AddUser($experience, $buildData['citizen']);
		// foreach($buildData['partners'] as $partner) $this->experienceManager->AddPartner($experience, $partner);
		$experience->save();

		//foreach($buildData['rates'] as $rate) $this->rateManager->AddRate($rate, $experience);
		foreach($buildData['tags'] as $tag) $this->tagManager->AddTag($tag, $experience);

		foreach($buildData['language_aliases'] as $alias) {
			$this->languageManager->AddLanguage($this->languageManager->FindByAlias($alias), $experience);
			$this->translationsSeeder->Translate($buildData['descriptions'], $alias, $experience, $this->descriptionManager, 'AddDescription');
			$this->translationsSeeder->Translate($buildData['slugs'], $alias, $experience, $this->slugManager, 'AddSlug');
		}
		$this->addressManager->AddAddress($buildData['meetingPoint'], $experience, 'meetingPoint');
	}

	/**
	 * @param $descriptions
	 * @return array
	 */
	private function slugsFromDescriptions($descriptions) {
		$slugs = [];
		foreach($descriptions as $description) {
			$slugs[] = [
				'lang' => $description['lang'],
				'data' => [
					'name' => $description['data']['title'],
					'type' => 'CityByCitizen\Experience'
				]
			];
		}
		return $slugs;
	}
}