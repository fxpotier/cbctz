<?php

namespace CityByCitizen\Services;

use CityByCitizen\Language;
use CityByCitizen\Tag;
use CityByCitizen\Translation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class TranslationManager {
	private $types;

	function __construct() {
		$this->types = [
			'Tags' => ['class' => Tag::class, 'field' => 'name'],
			'Languages' => ['class' => Language::class, 'field' => 'name'],
		];
	}

	/**
     * @return Translation
     */
    public function Create() {
        return new Translation;
    }

	/**
	 * @param Translation $translation
	 * @param Language $language
	 */
	public function AddLanguage(Translation $translation, Language $language) {
        $translation->language()->associate($language);
    }

	/**
	 * @param Translation $translation
	 * @param Model $reference
	 */
	public function AddReference(Translation $translation, Model $reference) {
        $translation['translated_reference'] = $reference['id'];
    }

	/**
	 * @param Translation $translation
	 * @param Model $model
	 */
    public function AddTranslation(Translation $translation, Model $model){
        $model->translation()->save($translation);
        //$model->save();
    }

	/**
	 * @param $data
	 * @param string $language
	 * @return Collection
	 */
	public function Translate($data, $language = 'english') {
        $lang = $language;
		if(!$lang instanceof Language) $lang = Language::where('name', '=', $language)->first();
        if(!$lang) $lang =  Language::where('alias', '=', $language)->first();
        if(!$lang) dd('Language Name or alias  not found ! : ' .$language);
		if(is_array($data)) $data = collect($data);

		if(!$data instanceof Collection) return $this->TranslateItem($data, $lang);
		$translated = [];
		foreach($data as $item) $translated[] = $this->TranslateItem($item, $lang);
		return collect($translated);
	}

	private function TranslateItem($item, $lang) {
		$itemTranslation = $this->GetReference($item);
		$langTranslation = $this->GetReference($lang);

		$translation = Translation::where('translated_reference', $itemTranslation->translated_reference)
			->where('translatable_type', get_class($item))
			->where('language_id', $langTranslation->translated_reference)
			->first();

		return is_null($translation) ? $item : $translation->translatable;
	}

    /**
     * @param $item
     * @return Language
     */
    public function GetLanguage($item) {
        return $item->translation[0]->language;
    }

	public function GetReference($item) {
		$itemTranslation = $item->translation;
		if($itemTranslation->count() == 0) return $item;

        $itemTranslation = $itemTranslation[0];
		if (is_null($itemTranslation->translated_reference)) return $item;
		return $itemTranslation;
	}

	public function Unmatched($type, $offset, $count) {
		if (!isset($this->types[$type])) return null;
		return $this->UnmatchedQuery($type, $this->types[$type])->skip($offset)->take($count)->get();
	}

	public function UnmatchedStat() {
		$data = [];
		foreach ($this->types as $type => $class)
			$data[$type] = $this->UnmatchedQuery($type, $class)->count();
		return $data;
	}

	public function TypeInfo($type) {
		return $this->types[$type];
	}

	private function UnmatchedQuery($table, $type) {
		$fields = [
			$table.'.id as id',
			$table.'.'.$type['field'].' as field',
		];

		$data = $type['class']::whereHas('translation', function($query) {
			$query->whereNull('translated_reference');
		})->with('translation.language')->select($fields);
		return $data;
	}

    public function delete($models) {
        if (is_array($models)) $models = collect($models);
        if ($models instanceof Collection) {
            foreach ($models as $model)
                $this->delete($model);
            return;
        }

        $models->translation()->delete();
    }
}
