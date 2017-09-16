<?php
/**
 * Created by PhpStorm.
 * User: Hinomi
 * Date: 08/05/2015
 * Time: 20:29
 */

namespace CityByCitizen\Http\Controllers;

use CityByCitizen\Description;
use CityByCitizen\Experience;
use CityByCitizen\Language;
use CityByCitizen\Services\AccountManager;
use CityByCitizen\Services\AddressManager;
use CityByCitizen\Services\DescriptionManager;
use CityByCitizen\Services\LanguageManager;
use CityByCitizen\Services\MangoPay;
use CityByCitizen\Services\PaymentManager;
use CityByCitizen\Services\PictureManager;
use CityByCitizen\Services\SlugManager;
use CityByCitizen\Services\TranslationManager;
use CityByCitizen\Services\UserManager;
use CityByCitizen\Translation;
use CityByCitizen\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Collection;
use ThunderArrow\Validation\Services\SuperValidator;

class ProfileController extends Controller {
	#region Profile

	#region attributes
	/**
	 * @var AccountManager
	 */
	private $accountManager;
	/**
	 * @var PictureManager
	 */
	private $pictureManager;
	/**
	 * @var AddressManager
	 */
	private $addressManager;
	/**
	 * @var TranslationManager
	 */
	private $translationManager;
	/**
	 * @var LanguageManager
	 */
	private $languageManager;
	/**
	 * @var DescriptionManager
	 */
	private $descriptionManager;
	/**
	 * @var SlugManager
	 */
	private $slugManager;
    /**
     * @var UserManager
     */
    private $userManager;
    /**
     * @var PaymentManager
     */
    private $paymentManager;

    #endregion

	function __construct(AccountManager $accountManager, PictureManager $pictureManager, AddressManager $addressManager,
						 TranslationManager $translationManager, LanguageManager $languageManager, DescriptionManager $descriptionManager,
						 SlugManager $slugManager, UserManager $userManager, PaymentManager $paymentManager) {
		$this->middleware('auth',['except' => ['getShow', 'getGenerateSlugsAndTranslations' ]]);
		$this->accountManager = $accountManager;
		$this->pictureManager = $pictureManager;
		$this->addressManager = $addressManager;
		$this->translationManager = $translationManager;
		$this->descriptionManager = $descriptionManager;
		$this->languageManager = $languageManager;
		$this->slugManager = $slugManager;
        $this->userManager = $userManager;
        $this->paymentManager = $paymentManager;
    }

	public function getIndex($alert = null) {
		$user = Auth::user()->user;
		$userDisplayLanguage = $user->displayLanguage->name;

		$available_languages = Language::where('can_display', '=', true)->groupby('alias')->distinct()->get();
		$display_languages = [];
		foreach($available_languages as $available_language)
			$display_languages[] = $this->translationManager->Translate($available_language, $available_language->name);

		$descriptions = [];
		foreach($user->description()->get() as $description) $descriptions[$description->translation->first()->language->alias] = $description;

        $spokenLanguages = $this->translationManager->Translate($user->languages, $userDisplayLanguage);
        foreach($spokenLanguages as $key => $lang)
            if($lang->alias == $user->mainLanguage->alias) $spokenLanguages->forget($key);

		return view('user.profile')
			->withUser($user->load('languages', 'address'))
			->withMainlanguage($this->translationManager->Translate($user->mainLanguage, $userDisplayLanguage))
			->withSpokenlanguages($spokenLanguages)
			->withLanguages($this->translationManager->Translate(Language::groupBy('alias')->distinct()->get(), $userDisplayLanguage))
			->withDisplaylanguages(json_encode($display_languages))
			->withUserdisplaylanguage(json_encode($user->displayLanguage))
			->withDescriptions(json_encode($descriptions));
	}

	public function postIndex(Request $request) {
		$profile = $request->only(['firstname', 'lastname', 'phone', 'gender', 'date', 'nationality']);
		$profile['phone'] = str_replace(" ", "", $profile['phone']);
		$address = $request->input('address');
		$alert = new \stdClass();
		$validator = SuperValidator::make('Profile', $profile)->validate('Address', $address);
		if ($validator->fails()) {
			return $this->getIndex()
				->withFailure("view/user/profile.error")
				->withErrors($validator->errors());
		}
		
		$account = Auth::user();

		$this->slugManager->Update($account->user, $request->input('firstname') . '-' . $request->input('lastname')[0]);
		$this->accountManager->UpdateProfile($account, $profile);

        $address = $this->addressManager->UpdateOrCreateAddress($account->user->address, $address);
        if(!$account->user->address) $account->user->address()->save($address);

		$this->accountManager->SetDisplayLanguage($account, Language::find($request->input('displayLanguage')));
		$mainLanguage = $this->languageManager->FindOrCreate(['name' => $request->input('mainLanguage')]);
		$this->accountManager->SetMainLanguage($account, $mainLanguage);
		$spokenLanguages = $this->translationManager->Translate($this->languageManager->FindOrCreate(collect($request->input('spokenLanguages'))))->unique();
		$mainLanguage = $this->translationManager->Translate($mainLanguage);
		$this->accountManager->UpdateLanguages($account, $spokenLanguages->diff(collect([$mainLanguage])));

		$descriptions = collect($request->input('descriptionRef'))->merge(collect($request->input('descriptions')));
		$this->descriptionManager->UpdateDescriptions($account->user, $descriptions, $descriptions->lists('language'));

		return $this->getIndex()->withSuccess("view/user/profile.success");
	}

	public function getShow($slug = null, $suffix = null) {
        $language = null;
        if($suffix) $language = Language::where('alias','=',$suffix)->first()->alias;

		if (!$slug && Auth::check()) {
			$user = Auth::user()->user;
			$slug = $user->slug[0]->name;
			if (!$language) $language = $user->mainLanguage->alias;
		} else if ($slug !== null) {
			$user = $this->slugManager->GetBySlug($slug, User::class);
			if (!$language) {
				if (!Auth::check()) {
					$language = $user->mainLanguage;
				} else {
					$citizenLanguages = $user->languages()->get()->groupBy('alias')->keys()->all();
					array_unshift($citizenLanguages, $user->mainLanguage->alias);
					$traveller = Auth::user()->user;
					$var = $traveller->languages()->get()->groupBy('alias')->keys()->all();
					array_unshift($var, $traveller->mainLanguage->alias);
					$language = array_intersect($var, $citizenLanguages);
					if (!empty($language)) $language = array_shift($language);
					else if (in_array($traveller->displayLanguage->alias, $citizenLanguages)) $language = $traveller->displayLanguage->alias;
					else  $language = $user->mainLanguage->alias;
				}
			}
		} else {
			return redirect(action('AccountController@getSignIn'));
		}

		$user->languages->prepend($user->mainLanguage);

		$trans = $this->translationManager->Translate($user->description,$language);
		if($trans != null ) {
			if($trans instanceof Collection) {
				if(!($trans->isEmpty()))$user->description = $trans[0];
				else $user->description = '';
			}
			else $user->description =  $trans;
		}
        //$user->description = $this->translationManager->Translate($user->description,$language)[0];

		//dd($user->travelsAsked, $user->travelRecieved);
		//dd($user->feedbacksReceived[0]->author->firstname, $user->feedbacksReceived[0]->value, $user->feedbacksReceived[0]->content);

		/*foreach($user->feedbacksReceived as $feedback) {
			dd($feedback->author->firstname, $feedback->value, $feedback->content);
		}*/


		$profilePicture = $user->profilePicture ? $user->profilePicture->source : 'img/app/users/no_profile.png';
		$coverPicture = $user->coverPicture ? $user->coverPicture->source : 'img/app/users/no_cover.png';
		$cities = [];
		$experiences = $user->experiences()->whereState('online')->get()->load('slug','description');

		foreach ($experiences as $experience) {
			$cities[] = $experience->area->address->city;
			$experience->description = $this->translationManager->Translate($experience->description,$language);

			$slugByAlias = [];
			foreach($experience->slug as $sl) $slugByAlias[$this->translationManager->GetLanguage($sl)->alias] = $sl->name;

			$experience->slugByAlias = $slugByAlias;

			$slugArray = $experience->slug;
			foreach ($slugArray as $slug) {
				if($slug->translation[0]->language->alias == $language) {
					$experience->slugName = $slug->name;
				}
			}
			if($experience->slugName == null) $experience->slugName = $experience->slug[0]->name;
		}


		$user->experiences = $experiences;

		return view('profile.show')
			->withUser($user)
			->withCities(collect($cities)->unique())
			->withProfilepicture($profilePicture)
			->withCoverpicture($coverPicture);
	}

	public function getPictures() {
		$profilePicture = Auth::user()->user->profilePicture ? Auth::user()->user->profilePicture->source :'img/app/users/no_profile.png';
		$coverPicture = Auth::user()->user->coverPicture ? Auth::user()->user->coverPicture->source : 'img/app/users/no_cover.png';

		return view('user.picture')
			->withProfilepicture($profilePicture)
			->withCoverpicture($coverPicture);
	}

	public function postPictures(Request $request) {
		$user = Auth::user()->user;
		$path = 'user-'.$user->id;

		$this->savePicture($request->input('profile')['data'], 'users/'.$path.'/pictures', 'profile', 'profile', $user->profilePicture, 'AddProfilePicture');
		$this->savePicture($request->input('cover')['data'], 'users/'.$path.'/pictures', 'cover', 'cover', $user->coverPicture, 'AddCoverPicture');

		$user->save();
		return Redirect::back();
	}

	private function savePicture($pictureData, $path, $name, $album, $destination, $addMethod) {
		$user = Auth::user()->user;
		if($pictureData) {
			$savePath = $this->pictureManager->SavePicture($name, $path , $pictureData);
			$picture = $this->pictureManager->UpdateOrCreate(['source' => $savePath, 'album' => $album], $destination);
			$this->userManager->$addMethod($user, $picture);
			$this->pictureManager->AddPicture($picture, $user);
		}
	}

	public function deletePicture(PictureManager $pictureManager, $name) {
		if (!$this->accountManager->HasPicture(Auth::user(), $name)) return Response::make(trans('resources.404'), 404);
		$pictureManager->DeletePicture($name);
		return Response::make('', 200);
	}

	public function getSettings() {
		return view('user.settings')->withAccount(Auth::user());
	}

	public function postSettings(Request $request) {
		$errors = $this->accountManager->UpdateSettings(Auth::user(), $request->all());
		if ($errors != null) return view('user.settings')->withAccount(Auth::user())->withErrors($errors);
		return redirect(action('ProfileController@getSettings'));
	}

	public function getBanking() {
		$account = Auth::user();
		$user = $account->user->load('payment');
		return view('user.banking')->withAccount($account)->withUser($user);
	}

    public function postBanking(Request $request, MangoPay $mangoPay) {
        $errors = $this->paymentManager->UpdateBanking($request, $mangoPay);
        if ($errors != null) return Redirect::back()->withMango($errors);
		$success['message'] = trans('utils/mangopay.success.editbanking');
        return redirect(action('ProfileController@getBanking'))->withSuccess($success);
    }

    public function getGenerateSlugsAndTranslations() {
        $users = User::all();
        foreach($users as $user)
        {
            $this->slugManager->CreateOrUpdate($user, $user->firstname . '-' . $user->lastname[0]);
            $descriptions = $user->description;
            $languages = $user->languages;
            if(!$languages->contains($user->mainLanguage))$languages->prepend($user->mainLanguage);
            $this->descriptionManager->UpdateDescriptions($user, $descriptions, $user->languages);
        }
    }
	#endregion
}