<?php
/**
 * Created by PhpStorm.
 * User: Marc
 * Date: 22/05/2015
 * Time: 13:56
 */

namespace CityByCitizen\Services;

use CityByCitizen\Description;
use CityByCitizen\Language;
use CityByCitizen\Translation;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

class DescriptionManager {
	/**
	 * @param $data
	 * @return Description
	 */
	public function Create($data) {
		if($data instanceof Collection) {
			$descriptions = [];
			foreach($data as $item) $descriptions[] = $this->Create($item);
			return collect($descriptions);
		}
        if($data instanceof Description) {
            $t = $data;
            $data = [
                'describable_id' => $t->describable_id,
                'describable_type' => $t->describable_type,
                'title' => $t->title,
                'content' => $t->content,
            ];
        }
		$description = Description::create($data);
		return $description;
	}

	/**
	 * @param $descriptions
	 * @param $reference
	 * @param $languages
	 */
	public function AddBashTranslation($descriptions, $reference, $languages) {
		$translationManager = new TranslationManager();
		$languageManager = new LanguageManager();

		foreach($languages as $key => $language)
			if(!$language instanceof Language) $languages[$key] = $languageManager->FindOrCreate(['name' => $language]);

		foreach($descriptions as $key => $description) {

            $translation = Translation::where('translatable_type','=',get_class($reference))->where('translatable_id','=',$description->id)->where('translated_reference','=',$reference->id)->where('language_id','=',$languages[$key]->id)->first();
			if($translation == null) {
                $translation = $translationManager->Create();
                $translationManager->AddLanguage($translation, $languages[$key]);
                $translationManager->AddReference($translation, $reference);
                $translationManager->AddTranslation($translation, $description);

            }
		}
	}

    /**
     * @param Description $description
     * @param Model $model
     * @param string $relation
     * @return Model
     */
    public function AddDescription($description, Model $model, $relation = '') {
		if($description instanceof Collection) foreach($description as $d) $this->AddDescription($d, $model, $relation);
		else if ($relation === '') $model->description()->save($description);
        else $model->$relation()->save($description);
    }

	public function UpdateDescriptions(Model $model, $descriptions, $languages, $relation = '') {
		if(!$descriptions instanceof Collection) $descriptions = collect($descriptions);
        Description::where('describable_type','=',get_class($model))->where('describable_id','=',$model->id)->delete();
        $descriptions = $this->Create($descriptions);
		$this->AddDescription($descriptions, $model, $relation);
        //var_dump($model->id);
       /* if($model->id == 26) {
            dd($model, $model->mainLanguage , $model->languages, $model->description);
        }*/

		$this->AddBashTranslation($descriptions, $descriptions->first(), $languages);
	}

    public function delete($descs) {
        if (is_array($descs)) $descs = collect($descs);
        if ($descs instanceof Collection) {
            foreach ($descs as $desc)
                $this->delete($desc);
            return;
        }

        $descs->delete();
    }
}