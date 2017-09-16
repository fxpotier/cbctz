<?php
/**
 * Created by PhpStorm.
 * User: Hinomi
 * Date: 28/05/2015
 * Time: 16:43
 */

namespace CityByCitizen\Http\Controllers;

use CityByCitizen\Services\TranslationManager;
use Illuminate\Database\Query\JoinClause;


class TranslationMatchController extends Controller {
	/**
	 * @var TranslationManager
	 */
	private $translationManager;

	function __construct(TranslationManager $translationManager) {
		$this->middleware('backoffice');
		$this->translationManager = $translationManager;
	}

	public function getIndex() {
		return view('backoffice.translation')->withTypes($this->translationManager->UnmatchedStat());
	}

	public function getUnmatched($type, $offset = 0, $count = 20) {
		$unmatched = $this->translationManager->Unmatched($type, $offset, $count);
		return is_null($unmatched) ? response('', 400) : $unmatched;
	}

	public function getMatching($type, $search, $count = 10) {
		$ti = $this->translationManager->TypeInfo($type);
		$model = $ti['class'];
		$field = $ti['field'];
		return $model::where($field, 'LIKE', '%'.$search.'%')->take($count)
			->leftJoin('translations', function(JoinClause $join) use($type, $model) {
			$join->on($type.'.id', '=', 'translations.translatable_id')->where('translations.translatable_type', '=', $model);
		})->whereNotNull('translations.translated_reference')
			->select($field.' as field')->get();
	}

	public function getMatch($type, $id, $match = null) {
		$ti = $this->translationManager->TypeInfo($type);
		$model = $ti['class'];
		$field = $ti['field'];

		$stringInst = $model::find($id);
		if (is_null($stringInst)) return response('String not found', 404);

		$translation = $stringInst->translation->first();
		if ($translation->translated_reference) return response('String already references another string', 400);

		if (!is_null($match)) {
			$matchInst = $model::where($field, $match)->first();
			if (is_null($matchInst)) return response('Reference string not found', 404);

			$matchTranslation = $matchInst->translation->first();
			$stringLang = $translation->language;
			$matchLang = $matchTranslation->language;

			if ($stringLang == $matchLang) return response('The given string and the reference are in the same language', 400);

			$translatedString = $this->translationManager->Translate($stringInst, $matchLang->name);

			if ($translatedString != $stringInst)
				return response('The given string is already translated in the reference\'s language: '.$translatedString->$field, 400);

			$translatedMatch = $this->translationManager->Translate($matchInst, $stringLang->name);
			if ($translatedMatch != $matchInst)
				return response('The reference string is already translated in the reference\'s language: '.$translatedMatch->$field, 400);

			if (is_null($matchTranslation->translated_reference)) {
				$this->translationManager->AddReference($matchTranslation, $matchInst);
				$matchTranslation->save();
			}

			$translation->translated_reference = $matchTranslation->translated_reference;
		} else {
			if (!is_null($translation->translated_reference)) return response('String already references another string');
			$this->translationManager->AddReference($translation, $stringInst);
		}

		$translation->save();
		return response('OK', 200);
	}
}