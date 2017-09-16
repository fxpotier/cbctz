<?php
/**
 * Created by PhpStorm.
 * User: Marc
 * Date: 10/06/2015
 * Time: 18:28
 */

namespace CityByCitizen\Services;

use CityByCitizen\Language;
use CityByCitizen\Tag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class TagManager {
	/**
	 * @param $data
	 * @return Tag
	 */
	public function Create($data) {
		if($data instanceof Collection) foreach($data as $item) $this->Create($item);
		$tagData = [];
		$tagData['name'] = isset($data['name']) ? $data['name'] : $data;
		$tagData['slug'] = Str::slug($tagData['name']);

		$tag = Tag::where('slug', '=', $tagData['slug'])->first();
		if($tag != null) return $tag;
		$tag = Tag::create($tagData);
		return $tag;
	}

	public function Clear(Model $model, $relation = 'tags') {
		/** @var Collection $tags */
		$model->$relation()->detach();
	}

	/**
	 * @param Tag $tag
	 * @param Model $model
	 * @param string $relation
	 */
	public function AddTag(Tag $tag, Model $model, $relation = 'tags') {
        if (!$model->$relation()->whereName($tag->name)->exists())
    		$model->$relation()->save($tag);
	}

    /**
     * @param $tag
     * @param $type
     * @return mixed
     */
    public function GetByTag($tag, $type) {
        //return Tag::where('name', '=', $tag)->where('taggable_type', '=', $type)->get()->taggable()->get();
    }

	/**
	 * @param $data
	 * @param Language $language
	 * @return static
	 */
	public function FindByQuery($data, Language $language = null) {
		if($data instanceof Collection) {
			$tags = [];
			foreach($data as $query) $tags[] = $this->FindByQuery($query, $language);
			return $tags;
		}
		else if($language) {
			return Tag::where('slug', 'LIKE', '%'.$data.'%')->where(function($query) use($language) {
				$query->whereDoesntHave('translation')
					->orWhereHas('translation', function($query) use($language) {
					$query->join('languages', 'languages.id', '=', 'translations.language_id')
						->where('languages.alias', $language->alias);
				});
			})->select('name')->get();
		}
		else return Tag::where('slug', 'LIKE', '%'.$data.'%')->select('name')->get();
	}
}