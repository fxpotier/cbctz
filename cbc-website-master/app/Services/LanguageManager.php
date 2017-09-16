<?php
/**
 * Created by PhpStorm.
 * User: Romain
 * Date: 25/05/2015
 * Time: 10:33
 */

namespace CityByCitizen\Services;

use Illuminate\Support\Collection;
use CityByCitizen\Language;
use Illuminate\Database\Eloquent\Model;

class LanguageManager {
    /**
     * @param $data
     * @return Language
     */
    public function Create($data) {
        $language = Language::create($data);
        return $language;
    }

	/**
	 * @param $data
	 * @return Language
	 */
	public function FindOrCreate($data) {
		if($data instanceof \Illuminate\Support\Collection) {
			$languages=[];
			foreach($data as $item) $languages[] = $this->FindOrCreate(['name' => $item]);
			return $languages;
		}
		$language = Language::where('name', $data['name'])->first();
		if(!$language) $language = $this->Create($data);
		return $language;
	}

	/**
	 * @param $data
	 * @return Language
	 */
	public function FindByAlias($data) {
		$language = Language::where('alias', $data)->first();
		return $language;
	}

	/**
	 * @param $language
	 * @param Model $model
	 * @param string $relation
	 */
	public function AddLanguage($language, Model $model, $relation = '') {
		if($language instanceof Collection) foreach($language as $l) $this->AddLanguage($l, $model, $relation);
		else if ($relation === '') $model->languages()->save($language);
		else $model->$relation()->save($language);
	}

	/**
	 * @param $data
	 * @param Language $language
	 * @return static
	 */
	public function FindByQuery($data, Language $language = null) {
		if($data instanceof Collection) {
			$languages = [];
			foreach($data as $query) $languages[] = $this->FindByQuery($query, $language);
			return $languages;
		}

		if($language) {
			$translationManager = new TranslationManager();
			$languagesFound = $translationManager->Translate(Language::groupBy('alias')->distinct()->get(), $language->name);
			$translatedLanguages = $languagesFound->filter(function($item) use ($data) {
				return strpos(strtolower($item->name), $data) !== false;
			});
			return $translatedLanguages;
		}
		else return Language::where('name', 'LIKE', '%'.$data.'%')->get();
	}
}