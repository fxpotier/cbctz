<?php
/**
 * Created by PhpStorm.
 * User: Marc
 * Date: 05/08/2015
 * Time: 10:46
 */

namespace CityByCitizen\Http\Controllers;

use CityByCitizen\Description;
use CityByCitizen\Experience;
use CityByCitizen\Services\DescriptionManager;
use CityByCitizen\Services\ExperienceManager;
use CityByCitizen\Services\SlugManager;
use CityByCitizen\Services\TranslationManager;
use CityByCitizen\Translation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use ThunderArrow\Validation\Services\SuperValidator;

class AdminExperienceController extends Controller {
	#region fields
	/**
	 * @var TranslationManager
	 */
	private $translationManager;
	/**
	 * @var ExperienceManager
	 */
	private $experienceManager;
	/**
	 * @var SlugManager
	 */
	private $slugManager;
	/**
	 * @var DescriptionManager
	 */
	private $descriptionManager;
	#endregion

	#region constructor
	/**
	 * @param TranslationManager $translationManager
	 * @param ExperienceManager $experienceManager
	 * @param SlugManager $slugManager
	 * @param DescriptionManager $descriptionManager
	 */
	function __construct(TranslationManager $translationManager, ExperienceManager $experienceManager, SlugManager $slugManager, DescriptionManager $descriptionManager) {
		$this->translationManager = $translationManager;
		$this->experienceManager = $experienceManager;
		$this->slugManager = $slugManager;
		$this->descriptionManager = $descriptionManager;
	}
	#endregion

	public function getIndex() {

		$user = Auth::user()->user;
		$experiences = Experience::get();

		foreach ($experiences as $exp) {
			$language = [];

			$expLanguages = $exp->languages()->get()->groupBy('alias')->keys()->all();
			$var = $user->languages()->get()->groupBy('alias')->keys()->all();
			array_unshift($var, $user->mainLanguage->alias);

			$language = array_intersect($var, $expLanguages);

			if(!empty($language)) $language = array_shift($language);
			else if(in_array($user->displayLanguage->alias, $expLanguages)) $language = $user->displayLanguage->alias;
			else $language = $exp->citizen->mainLanguage->alias;

			if($exp->description == null) var_dump($exp->id);
			else $exp->description = $this->translationManager->Translate($exp->description,$language);

			$slugByAlias = [];
			foreach($exp->slug as $sl) {
                $slugByAlias[$this->translationManager->GetLanguage($sl)->alias] = $sl->name;

            }

			$exp->slugByAlias = $slugByAlias;

			$slugArray = $exp->slug;
           /* if($exp->id == 23) {
                dd($exp->slug, $exp->slug()->get(),  $exp->$description);
                //$exp->$description;
                //$refSlug = $this->experienceManager->CreateSlug($lang, $descriptions[$key]['title'], $exp, $refSlug);
                $exp->slug->save();
            }*/
            $exp->slugName = null;
			foreach ($slugArray as $slug) {
                if($slug->translation[0]->language->alias == $language) {
                    $exp->slugName = $slug->name;
                }
            }



		}

		return view('backOffice.experience.index')->withExperiences($experiences->groupBy('state')->reverse());
	}

	#region Edit
	public function getEdit($slug) {
		/** @var Experience $experience */
		$experience = $this->slugManager->GetBySlug($slug, Experience::class);
		$user = $experience->citizen;
		$mainLanguage = $user->mainLanguage;
		$this->experienceManager->GetEdit($experience, $mainLanguage, $thumbnail, $cover, $descriptionPictures, $translations, $descr, $tags, $prices);

		return view('backOffice.experience.edit')
			->withUser($user)
			->withExperience($experience)
			->withThumbnail($thumbnail)
			->withCover($cover)
			->with('descriptionPictures', json_encode($descriptionPictures))
			->withTranslations(json_encode($translations))
			->withDescriptions(json_encode($descr))
			->withTags(json_encode($tags))
			->withPrices($prices)
			->withSlug($slug);
	}

	public function postEdit(Request $request, $slug) {
		$address = $request->get('address');
		$address['country'] = $request->get('country');
		$validator = SuperValidator::make('Experience', $request->only('duration', 'min_persons', 'max_persons', 'costs'))
			->validate('Area', $request->only('first-city', 'country', 'distance'))
			->validate('ExperienceAddress', $address)
			->validate('ExperienceDescription', $request->only('title', 'content'))
			->validateMultiple('ExperienceDescription',$request->get('descriptions') ?: [],'descriptions')
			->validate('Tag', $request->get('tags') ?: [])
			->validate('Tag', $request->get('transportation') ?: [])
			->validate('Tag', $request->get('cities') ?: [])
			->validate('Image', $request->get('main') ?: [])
			->validate('Image', $request->get('cover') ?: [])
			->validateMultiple('Image',$request->get('descriptionPictures') ?: [],'descriptionPictures');


		if ($validator->fails()) return redirect(action('AdminExperienceController@getEdit', $slug))->withInputs($request->all())->withErrors($validator->errors());

		/** @var Experience $experience */
		$experience = $this->slugManager->GetBySlug($slug, Experience::class);

		$payment = $experience->citizen->payment;
		if(!$payment || !$payment->wallet_id || !$payment->bank_id) {
			$state = 'validating';
		} else  $state = 'online';

		$this->experienceManager->PostEdit($experience, $experience->citizen, $state, $request);

		return redirect(action('AdminExperienceController@getIndex'));
	}
	#endregion

	#region Calendar
	public function getCalendar($slug) {
		return view('backOffice.experience.calendar')->withSlug($slug);
	}

	public function getCalendarEvents($slug, $offset = 0) {
		$experience = $this->slugManager->GetBySlug($slug, Experience::class);
		return json_encode($this->experienceManager->GetEvents($experience, $offset));
	}

	public function postCalendar(Request $req, $slug) {
		$events = $req->only('events')['events'];
		$offset = $req->only('offset')['offset'];
		$experience = $this->slugManager->GetBySlug($slug, Experience::class);
		$this->experienceManager->PostEvents($experience, $events, $offset);
	}
	#endregion

	public function postState(Request $request, $slug) {
		$experience = $this->slugManager->GetBySlug($slug, Experience::class);
		$experience->state = $request->get('state');
		$experience->save();
	}

	public function postDelete($slug) {
		$experience = $this->slugManager->GetBySlug($slug, Experience::class);
		$experience->delete();
	}
}