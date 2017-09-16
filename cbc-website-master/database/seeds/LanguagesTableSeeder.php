<?php
/**
 * Created by PhpStorm.
 * User: Hinomi
 * Date: 07/05/2015
 * Time: 11:24
 */

namespace CityByCitizen\Seeds;

use CityByCitizen\Language;
use CityByCitizen\Services\LanguageManager;
use CityByCitizen\Services\TranslationManager;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LanguagesTableSeeder extends Seeder {

	private $translationManager;
	private $languageManager;

	function __construct(TranslationManager $translationManager, LanguageManager $languageManager) {
		$this->translationManager = $translationManager;
		$this->languageManager = $languageManager;
	}

	public function run() {

		/*$english = $this->languageManager->Create(['name' => 'English', 'alias' => 'en', 'can_display' => true]);
		$french = $this->languageManager->Create(['name' => 'French', 'alias' => 'fr', 'can_display' => true]);
		$german = $this->languageManager->Create(['name' => 'German', 'alias' => 'de', 'can_display' => false]);
		$spanish = $this->languageManager->Create(['name' => 'Spanish', 'alias' => 'es', 'can_display' => false]);
		$italian = $this->languageManager->Create(['name' => 'Italian', 'alias' => 'it', 'can_display' => false]);
		$japanese = $this->languageManager->Create(['name' => 'Japanese', 'alias' => 'jp', 'can_display' => false]);

		$this->makeTranslation($english, $english, $english);
		$this->makeTranslation($english, $french, $french);
		$this->makeTranslation($english, $german, $german);
		$this->makeTranslation($english, $spanish, $spanish);
		$this->makeTranslation($english, $italian, $italian);
		$this->makeTranslation($english, $japanese, $japanese);

		$this->makeTranslation($french, $english, $this->languageManager->Create(['name' => 'Anglais']));
		$this->makeTranslation($french, $french, $this->languageManager->Create(['name' => 'Français']));
		$this->makeTranslation($french, $german, $this->languageManager->Create(['name' => 'Allemand']));
		$this->makeTranslation($french, $spanish, $this->languageManager->Create(['name' => 'Espagnol']));
		$this->makeTranslation($french, $italian, $this->languageManager->Create(['name' => 'Italien']));
		$this->makeTranslation($french, $japanese, $this->languageManager->Create(['name' => 'Japonais']));*/

		$english = $this->CreateLanguage('English', 'en', true);
		$french = $this->CreateLanguage('French', 'fr', true, $english);
		$german = $this->CreateLanguage('German', 'de', false, $english);
		$spanish = $this->CreateLanguage('Spanish', 'es', false, $english);
		$italian = $this->CreateLanguage('Italian', 'it', false, $english);
		$japanese = $this->CreateLanguage('Japanese', 'jp', false, $english);

		$this->CreateLanguage('Anglais', 'en', true, $french);
		$this->CreateLanguage('Français', 'fr', true, $french);
		$this->CreateLanguage('Allemand', 'de', false, $french);
		$this->CreateLanguage('Espagnol', 'es', false, $french);
		$this->CreateLanguage('Italien', 'it', false, $french);
		$this->CreateLanguage('Japonais', 'jp', false, $french);

		$this->CreateLanguage('Englisch', 'en', true, $german);
		$this->CreateLanguage('Französisch', 'fr', true, $german);
		$this->CreateLanguage('Deutsch', 'de', false, $german);
		$this->CreateLanguage('Spanisch', 'es', false, $german);
		$this->CreateLanguage('Italienisch', 'it', false, $german);
		$this->CreateLanguage('Japanisch', 'jp', false, $german);

		$this->CreateLanguage('Inglés', 'en', true, $spanish);
		$this->CreateLanguage('Francés', 'fr', true, $spanish);
		$this->CreateLanguage('Tedesco', 'de', false, $spanish);
		$this->CreateLanguage('Español', 'es', false, $spanish);
		$this->CreateLanguage('Italiano', 'it', false, $spanish);
		$this->CreateLanguage('Japonés', 'jp', false, $spanish);

		$this->CreateLanguage('Inglese', 'en', true, $italian);
		$this->CreateLanguage('Francese', 'fr', true, $italian);
		$this->CreateLanguage('Alemàn', 'de', false, $italian);
		$this->CreateLanguage('Spagnolo', 'es', false, $italian);
		$this->CreateLanguage('Italiano', 'it', false, $italian);
		$this->CreateLanguage('Giapponese', 'jp', false, $italian);

		$this->CreateLanguage('英語', 'en', true, $japanese);
		$this->CreateLanguage('フランス語', 'fr', true, $japanese);
		$this->CreateLanguage('ドイツ語', 'de', false, $japanese);
		$this->CreateLanguage('スペイン語', 'es', false, $japanese);
		$this->CreateLanguage('イタリア語', 'it', false, $japanese);
		$this->CreateLanguage('日本語', 'jp', false, $japanese);
		$this->initReferences();
	}

	private function CreateLanguage($name, $alias, $canDisplay = false, $language = null) {
		$newLang = $this->languageManager->Create(['name' => $name, 'alias' => $alias, 'can_display' => $canDisplay]);
		$this->makeTranslation($language ?: $newLang, null, $newLang);
		return $newLang;
	}

	private function makeTranslation($translationLanguage, $referenceItem, $itemToTranslate) {
		$translation = $this->translationManager->Create();
		$this->translationManager->AddLanguage($translation, $translationLanguage);
		if (!is_null($referenceItem)) $this->translationManager->AddReference($translation, $referenceItem);
		$this->translationManager->AddTranslation($translation, $itemToTranslate);
	}

	private function initReferences() {
		$aliases = DB::table('languages')->select('alias')->distinct()->get();
		foreach ($aliases as $alias)
			$this->initAliasReferences($alias->alias);
	}

	private function initAliasReferences($alias) {
		$languages = Language::whereAlias($alias)->with('translation')->get();
		$ref = $languages[0];

		foreach ($languages as $lang) {
			$this->translationManager->AddReference($lang->translation[0], $ref);
			$lang->translation[0]->save();
		}
	}
}