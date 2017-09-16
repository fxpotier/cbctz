<?php
/**
 * Created by PhpStorm.
 * User: Marc
 * Date: 11/06/2015
 * Time: 14:24
 */

namespace CityByCitizen\Seeds;

use CityByCitizen\Language;
use CityByCitizen\Services\TagManager;
use CityByCitizen\Services\TranslationManager;
use CityByCitizen\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class TagsSeeder extends Seeder {
	#region attributes
	/**
	 * @var TagManager
	 */
	private $tagManager;
	/**
	 * @var TranslationManager
	 */
	private $translationManager;
	#endregion

	#region constructor
	/**
	 * @param TagManager         $tagManager
	 * @param TranslationManager $translationManager
	 */
	function __construct (TagManager $tagManager, TranslationManager $translationManager) {
		$this->tagManager = $tagManager;
		$this->translationManager = $translationManager;
	}
	#endregion

	/**
	 * @param $dataToSeed
	 * @return array|Tag
	 */
	public function Create($dataToSeed) {
		if($dataToSeed instanceof Collection) {
			$tags = [];
			foreach ($dataToSeed as $tag) $tags[] = $this->Create($tag);
			return $tags;
		}

		$tag = $this->tagManager->Create($dataToSeed);
		$tag->save();
		$this->makeTranslation(Language::whereAlias('en')->first(), null, $tag);
		return $tag;
	}

	private function makeTranslation($translationLanguage, $referenceItem, $itemToTranslate) {
		$translation = $this->translationManager->Create();
		$this->translationManager->AddLanguage($translation, $translationLanguage);
		if (!is_null($referenceItem)) $this->translationManager->AddReference($translation, $referenceItem);
		$this->translationManager->AddTranslation($translation, $itemToTranslate);
	}
}