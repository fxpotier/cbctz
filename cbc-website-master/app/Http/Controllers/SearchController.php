<?php
/**
 * Created by PhpStorm.
 * User: Romain
 * Date: 22/06/2015
 * Time: 16:19
 */

namespace CityByCitizen\Http\Controllers;


use CityByCitizen\Experience;
use CityByCitizen\Language;
use CityByCitizen\Services\ExperienceManager;
use CityByCitizen\Services\SlugManager;
use CityByCitizen\Services\TagManager;
use CityByCitizen\Services\TranslationManager;
use CityByCitizen\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller {
    #region Attributes
    /**
     * @var ExperienceManager
     */
    private $experienceManager;
    /**
     * @var SlugManager
     */
    private $slugManager;
    /**
     * @var TranslationManager
     */
    private $translationManager;


    #endregion

    function __construct(ExperienceManager $experienceManager, SlugManager $slugManager, TagManager $tagManager, TranslationManager $translationManager) {
        $this->experienceManager = $experienceManager;
        $this->slugManager = $slugManager;
        $this->tagManager = $tagManager;
        $this->translationManager = $translationManager;
    }

    public function getSearch($search = null, $suffix = null) {
        if(!$search) return view('search.result')->withSearch('')->withExperiences(Experience::whereState('online')->get());

        $tags = explode(',', urldecode($search));
        $taggedExperiences = new Collection();

        foreach ($tags as $key=>$tag) {
            $tagFound = Tag::where('slug','like', '%'.str_slug($tag).'%')->get();
            if(!$tagFound->isEmpty()) $tags[$key] = $tagFound->first()->name;
            $taggedExperiences = $taggedExperiences->merge(collect($tagFound));
        }

        $experiences = new Collection();
        foreach ($taggedExperiences as $taggedExp) {
            $experiences = $experiences->merge(collect($taggedExp->experiences()->whereState('online')->get()));
        }

        $uniques = array();
        foreach ($experiences as $e) {
            $uniques[$e->id] = $e;
        }

        $result = array();
        foreach ($uniques as $exp) {
            $language = [];
            if($suffix) $language = Language::where('alias','=',$suffix)->first()->alias;
            else if(Auth::check()) {
                $user = Auth::user()->user;
                $expLanguages = $exp->languages()->get()->groupBy('alias')->keys()->all();
                $var = $user->languages()->get()->groupBy('alias')->keys()->all();
                array_unshift($var, $user->mainLanguage->alias);

                $language = array_intersect($var, $expLanguages);

                if(!empty($language)) $language = array_shift($language);
                else if(in_array($user->displayLanguage->alias, $expLanguages)) $language = $user->displayLanguage->alias;
                else $language = $exp->citizen->mainLanguage->alias;
            }
            else $language = $exp->citizen->mainLanguage->alias;

            $exp->description = $this->translationManager->Translate($exp->description,$language);

            $slugByAlias = [];
            foreach($exp->slug as $sl) $slugByAlias[$this->translationManager->GetLanguage($sl)->alias] = $sl->name;

            $exp->slugByAlias = $slugByAlias;

            $slugArray = $exp->slug;
            foreach ($slugArray as $slug)
                if($slug->translation[0]->language->alias == $language) $exp->slugName = $slug->name;

            $result[] = $exp;
        }

        return view('search.result')->withExperiences($result)->withSearch(json_encode($tags));
    }
}