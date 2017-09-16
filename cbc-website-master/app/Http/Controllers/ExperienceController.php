<?php
/**
 * Created by PhpStorm.
 * User: Hinomi
 * Date: 27/05/2015
 * Time: 09:44
 */

namespace CityByCitizen\Http\Controllers;

use CityByCitizen\Address;
use CityByCitizen\Description;
use CityByCitizen\Experience;
use CityByCitizen\Language;
use CityByCitizen\Services\AddressManager;
use CityByCitizen\Services\AreaManager;
use CityByCitizen\Services\DescriptionManager;
use CityByCitizen\Services\EventManager;
use CityByCitizen\Services\ExperienceManager;
use CityByCitizen\Services\LanguageManager;
use CityByCitizen\Services\LocalizationService;
use CityByCitizen\Services\PictureManager;
use CityByCitizen\Services\SlugManager;
use CityByCitizen\Services\TagManager;
use CityByCitizen\Services\TranslationManager;
use CityByCitizen\Services\TravelManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use ThunderArrow\Validation\Services\SuperValidator;

class ExperienceController extends Controller {
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
     * @var TravelManager
     */
    private $travelManager;
    /**
     * @var EventManager
     */
    private $eventManager;
	/**
	 * @var AddressManager
	 */
	private $addressManager;
	/**
	 * @var LanguageManager
	 */
	private $languageManager;

	/**
	 * @var DescriptionManager
	 */
	private $descriptionManager;

	/**
	 * @var TranslationManager
	 */
	private $translationManager;
	/**
	 * @var AreaManager
	 */
	private $areaManager;
	/**
	 * @var TagManager
	 */
	private $tagManager;

	/**
	 * @var PictureManager
	 */
	private $pictureManager;
	#endregion

    #region Constructor
	/**
	 * @param ExperienceManager $experienceManager
	 * @param SlugManager $slugManager
	 * @param TravelManager $travelManager
	 * @param EventManager $eventManager
	 * @param LanguageManager $languageManager
	 * @param AddressManager $addressManager
	 * @param DescriptionManager $descriptionManager
	 * @param TranslationManager $translationManager
	 * @param AreaManager $areaManager
	 * @param TagManager $tagManager
	 * @param PictureManager $pictureManager
	 */
	function __construct(ExperienceManager $experienceManager, SlugManager $slugManager, TravelManager $travelManager,
						 EventManager $eventManager, LanguageManager $languageManager, AddressManager $addressManager,
						 DescriptionManager $descriptionManager, TranslationManager $translationManager, AreaManager $areaManager,
						 TagManager $tagManager, PictureManager $pictureManager, LocalizationService $localizationService) {
		$this->experienceManager = $experienceManager;
		$this->slugManager = $slugManager;
        $this->travelManager = $travelManager;
        $this->eventManager = $eventManager;
		$this->languageManager = $languageManager;
		$this->addressManager = $addressManager;
		$this->descriptionManager = $descriptionManager;
		$this->translationManager = $translationManager;
		$this->areaManager = $areaManager;
		$this->tagManager = $tagManager;
		$this->pictureManager = $pictureManager;
        $this->localizationService = $localizationService;
    }
    #endregion

    #region Create
	public function getIndex() {
		return Redirect::action("ExperienceController@getCreate");
	}

    public function getCreate() {
        $user = Auth::user()->user->load('payment','experiences','displayLanguage','mainLanguage');
        $thumbnail = 'img/app/experiences/no_thumbnail.jpg';
        $cover = 'img/app/experiences/no_cover.png';

        $experiences = $user->experiences;
        $creating = false;

        foreach ($experiences as $exp) {
            if($exp->state == 'creating') $creating = true;
            $language = [];

            $expLanguages = $exp->languages()->get()->groupBy('alias')->keys()->all();
            $var = $user->languages()->get()->groupBy('alias')->keys()->all();
            array_unshift($var, $user->mainLanguage->alias);

            $language = array_intersect($var, $expLanguages);

            if(!empty($language)) $language = array_shift($language);
            else if(in_array($user->displayLanguage->alias, $expLanguages)) $language = $user->displayLanguage->alias;
            else $language = $exp->citizen->mainLanguage->alias;

            $exp->description = $this->translationManager->Translate($exp->description,$language);

            $slugByAlias = [];
            foreach($exp->slug as $sl) {
                $slugByAlias[$this->translationManager->GetLanguage($sl)->alias] = $sl->name;
            }

            $exp->slugByAlias = $slugByAlias;

            $slugArray = $exp->slug;
            foreach ($slugArray as $slug)
                if($slug->translation[0]->language->alias == $language) $exp->slugName = $slug->name;
        }

        $message = null;
        $payment = $user->payment;
        if ($creating) {
            if(!$payment || !$payment->wallet_id || !$payment->bank_id) {
                $message = trans('view/experience/create.message.banking-link');
            }
        }

        return view('experience.create')
            ->withUser($user)
            ->withExperiences($experiences->groupBy('state')->reverse())
            ->withMessage($message)
            ->withThumbnail($thumbnail)
            ->withCover($cover);
    }

	public function postIndex(Request $request) {
		$address = $request->get('address');
		$address['country'] = $request->get('country');
        //dd($request->all());
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
		if ($validator->fails()) return redirect(action('ExperienceController@getCreate'))->withInputs($request->all())->withErrors($validator->errors());

		$country = $request->get('country');

		$user = Auth::user()->user;
		$area = $this->experienceManager->SaveArea($request->only(['first-city', 'distance']), $country);

		$experience = new Experience();
		$this->experienceManager->AddArea($experience, $area);
		$this->experienceManager->AddUser($experience, $user);
		$experience->save();
		$experience = $this->experienceManager->SaveExperience($request->only(['days', 'hours', 'minutes', 'min_persons', 'max_persons', 'costs']), 'creating', $experience);

		$meetingPoint = $this->experienceManager->SaveMeetingPoint($request->get('address'), $country);

		$this->addressManager->AddAddress($meetingPoint, $experience, 'meetingPoint');

		$this->experienceManager->SaveTags($request->only(['first-city', 'tags', 'transportation', 'cities']), $experience);

        $translations = $request->get('translations') ?: [];
        array_unshift($translations, $user->mainLanguage->name);

        $descriptions = $request->get('descriptions');
        $descriptions[$translations[0]] = ['title' => $request->get('title'), 'content' => $request->get('content')];

        $reflang = $this->languageManager->FindOrCreate(['name' => $translations[0]]);
        $refSlug = null;
        $refDescription = null;
        foreach ($translations as $langName) {
            $lang = $this->experienceManager->CreateTranslation($langName, $reflang, $experience);
            $refSlug = $this->experienceManager->CreateSlug($lang, $descriptions[$langName]['title'], $experience, $refSlug);
            $refDescription = $this->experienceManager->CreateDescription($lang, $descriptions[$langName], $experience, $refDescription);
        }

		$path = 'users/user-'.$user->id.'/experiences/experience-'.$experience->id;
		$this->experienceManager->SavePicture($experience, $request->input('cover')['data'], $path, 'cover', 'cover', $experience->coverPicture, 'AddCoverPicture');
		$this->experienceManager->SavePicture($experience, $request->input('main')['data'], $path, 'thumbnail', 'thumbnail', $experience->thumbnailPicture, 'AddThumbnailPicture');

		$descriptionPictures = $request->input('descriptionPictures');
		if($descriptionPictures) {
			foreach ($descriptionPictures as $key => $picture) {
				$uid = time() . '_' . str_random(10);
				$this->experienceManager->SavePicture($experience, $picture['data'], $path . '/descriptions', 'description_' . $uid . '_' . $key, 'description', $experience->descriptionPictures, 'AddDescriptionPicture');
			}
		}

		$experience->save();
		return Redirect::action('ExperienceController@getCalendar', $refSlug->name);
	}
    #endregion

    #region Edit
    public function getEdit($slug) {
        $user = Auth::user()->user;
        $mainLanguage = $user->mainLanguage;

        /** @var Experience $experience */
        $experience = $this->slugManager->GetBySlug($slug, Experience::class);
		$this->experienceManager->GetEdit($experience, $mainLanguage, $thumbnail, $cover, $descriptionPictures, $translations, $descr, $tags, $prices);

		return view('experience.edit')
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
        if ($validator->fails()) return redirect(action('ExperienceController@getEdit', $slug))->withInputs($request->all())->withErrors($validator->errors());

        /** @var Experience $experience */
        $experience = $this->slugManager->GetBySlug($slug, Experience::class);

        $payment = Auth::user()->user->payment;
            if(!$payment || !$payment->wallet_id || !$payment->bank_id) {
               $state = 'creating';
            } else  $state = 'validating';

        $this->experienceManager->PostEdit($experience, Auth::user()->user, $state, $request);

        return redirect(action('ExperienceController@getCreate'));
    }
    #endregion

    #region Calendar
    public function getCalendar($slug) {
		return view('experience.calendar')->withSlug($slug);
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

    public function getShow($slug, $suffix = null) {
        $exp = $this->slugManager->GetBySlug($slug, Experience::class)->load('feedbacks');

        if(!Auth::check()) {
            if ($exp == null || ($exp->state != 'online')) abort(404);
        }
        else if (!$exp->citizen === Auth::user()->user && ($exp == null || ($exp->state != 'online'))) abort(404);

        if($suffix) $language = Language::where('alias','=',$suffix)->first()->alias;
        else if (!Auth::check()) {
            $language = $this->translationManager->GetLanguage($this->slugManager->FindSlug($slug, Experience::class))->alias;
        }
        else {
            $user = Auth::user()->user;
            $expLanguages = $exp->languages()->get()->groupBy('alias')->keys()->all();
            $var = $user->languages()->get()->groupBy('alias')->keys()->all();
            array_unshift($var, $user->mainLanguage->alias);
            $language = array_intersect($var, $expLanguages);
            if(!empty($language)) $language = array_shift($language);
            else if(in_array($user->displayLanguage->alias, $expLanguages)) $language = $user->displayLanguage->alias;
            else $language = $exp->citizen->mainLanguage->alias;
        }

        //Récupère toutes les traductions de la description
		$exp->description = $this->translationManager->Translate($exp->description,$language);
		$exp->citizen->description = $this->translationManager->Translate($exp->citizen->description,$language);
        $exp->citizen->languages->prepend($exp->citizen->mainLanguage);

        $slugByAlias = [];
        foreach($exp->slug as $sl) $slugByAlias[$this->translationManager->GetLanguage($sl)->alias] = $sl->name;
        $exp->slugByAlias = $slugByAlias;

		//TODO Tags translation when search is optimized.
		//$tags = $exp['relations']['tag'];

        return view('experience.show')->withExperience($exp)
			->withSlug($slug);

    }

    public function getEvents(Request $request) {
        $year = $request->input('year');
        $experience =  $request->input('experience');
        return $this->eventManager->getEvents($experience,$year);
    }

	public function postState(Request $request, $slug) {
		$experience = $this->slugManager->GetBySlug($slug, Experience::class);
		$experience->state = $request->get('state');
		$experience->save();
	}

	public function postDelete($slug) {
		$experience = $this->slugManager->GetBySlug($slug, Experience::class);
		$experience->delete();
	}

    public function getUpdateAddresses() {
        $addresses = Address::all();

        foreach($addresses as $address) {
            $this->addressManager->UpdateOrCreateAddress($address,$address);
        }
    }

    public function getGenerateSlugsAndTranslations() {
        $experiences = Experience::all();
        foreach($experiences as $exp)
        {
            $descriptions = Description::where('describable_id','=',$exp->id)->where('describable_type','=',Experience::class)->get();

            $langs = $exp->languages;
            $reflang = $exp->languages[0];
            $refSlug = null;
            $refDescription = null;
            foreach ($langs as $key => $language) {
                $lang = $this->experienceManager->CreateTranslation($language->name, $reflang, $exp);
                $refSlug = $this->experienceManager->CreateSlug($lang, $descriptions[$key]['title'], $exp, $refSlug);
                $refDescription = $this->experienceManager->CreateDescription($lang, $descriptions[$key], $exp, $refDescription);
            }
        }
    }

}
