<?php
/**
 * Created by PhpStorm.
 * User: Marc
 * Date: 11/06/2015
 * Time: 15:30
 */

namespace CityByCitizen\Seeds;

use CityByCitizen\Language;
use CityByCitizen\Services\TranslationManager;
use CityByCitizen\Translation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class TranslationsSeeder extends Seeder {
	#region attributes
	/**
	 * @var TranslationManager
	 */
	private $translationManager;
	#endregion

	#region constructor
	function __construct (TranslationManager $translationManager) {
		$this->translationManager = $translationManager;
	}
	#endregion

	/**
	 * @param $dataToSeed
	 * @return array|Translation
	 */
	public function Create($dataToSeed) {
		if($dataToSeed instanceof Collection) {
			$translations = [];
			foreach ($dataToSeed as $translation) $translations[] = $this->Create($translation);
			return $translations;
		}
		else {
			$translation = $this->translationManager->Create();
			$language =  Language::where('alias', '=', $dataToSeed)->first();
			$this->translationManager->AddLanguage($translation, $language);
			return $translation;
		}
	}

	/**
	 * @param $data
	 * @param $alias
	 * @param $experience
	 * @param $manager
	 * @param $method
	 */
	public function Translate($data, $alias, $experience, $manager, $method) {
		$translation = $this->Create($alias);
		$manager->$method($data[$alias], $experience);
		$this->translationManager->AddReference($translation, reset($data));
		$this->translationManager->AddTranslation($translation, $data[$alias]);
	}
} 