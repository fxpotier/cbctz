<?php namespace CityByCitizen\Http\Controllers;

use CityByCitizen\Experience;
use CityByCitizen\Language;
use CityByCitizen\Services\MangoPay;
use CityByCitizen\Services\TranslationManager;
use CityByCitizen\User;
use Illuminate\Support\Facades\Auth;

class WelcomeController extends Controller {


    function __construct(TranslationManager $translationManager) {

        $this->translationManager = $translationManager;
    }

    /**
     * Show the application welcome screen to the auth.
     * @param MangoPay $mangoPay
     * @param null $suffix
     * @return Response
     */
	public function getIndex(MangoPay $mangoPay, $suffix = null) {
        $experiences = Experience::orderByRaw("RAND()")->ofState('online')
            ->with('citizen', 'citizen.slug', 'tags', 'languages', 'description', 'slug', 'area', 'area.address', 'thumbnailPicture')
            ->take(6)->get();

        foreach ($experiences as $exp) {
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
        }

        return view('welcome.main')
			->withUsers(User::orderByRaw("RAND()")
				->with('slug')
				->where('profile_picture_id', '!=', 'null')
				->with('profilePicture')
				->take(12)->get())
			->withExperiences($experiences);
	}
}