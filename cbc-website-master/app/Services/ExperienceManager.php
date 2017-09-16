<?php

namespace CityByCitizen\Services;

use Carbon\Carbon;
use CityByCitizen\Address;
use CityByCitizen\Area;
use CityByCitizen\Description;
use CityByCitizen\Event;
use CityByCitizen\Experience;
use CityByCitizen\Partner;
use CityByCitizen\Picture;
use CityByCitizen\Slug;
use CityByCitizen\Translation;
use CityByCitizen\User;
use Illuminate\Support\Str;

/**
 * Class ExperienceManager
 * @package CityByCitizen\Services
 */
class ExperienceManager {
	#region Attributes
	/**
	 * @var SlugManager
	 */
	private $slugManager;
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
	/**
	 * @var EventManager
	 */
	private $eventManager;
	#endregion

	#region Constructor
	/**
	 * @param SlugManager $slugManager
	 * @param LanguageManager $languageManager
	 * @param AddressManager $addressManager
	 * @param DescriptionManager $descriptionManager
	 * @param TranslationManager $translationManager
	 * @param AreaManager $areaManager
	 * @param TagManager $tagManager
	 * @param PictureManager $pictureManager
	 * @param EventManager $eventManager
	 */
	function __construct(SlugManager $slugManager, LanguageManager $languageManager, AddressManager $addressManager,
						 DescriptionManager $descriptionManager, TranslationManager $translationManager, AreaManager $areaManager,
						 TagManager $tagManager, PictureManager $pictureManager, EventManager $eventManager) {
		$this->slugManager = $slugManager;
		$this->languageManager = $languageManager;
		$this->addressManager = $addressManager;
		$this->descriptionManager = $descriptionManager;
		$this->translationManager = $translationManager;
		$this->areaManager = $areaManager;
		$this->tagManager = $tagManager;
		$this->pictureManager = $pictureManager;
		$this->eventManager = $eventManager;
	}
	#endregion

	/**
	 * @param $data
	 * @return Experience
	 */
	public function Create($data) {
        $experience =  new Experience([
            'duration' => $data['duration_days'] * 1440 + $data['duration_hours'] * 60 + $data['duration_minutes'],
            'min_persons' => $data['min_persons'],
            'max_persons' => $data['max_persons'],
            'incurred_cost' => $data['incurred_transportation_cost'] + $data['incurred_food_drink_cost'] + $data['incurred_ticket_cost'] + $data['incurred_other_cost'],
            'incurred_transportation_cost' => $data['incurred_transportation_cost'],
            'incurred_food_drink_cost' => $data['incurred_food_drink_cost'],
            'incurred_ticket_cost' => $data['incurred_ticket_cost'],
            'incurred_other_cost' => $data['incurred_other_cost'],
            'incurred_cost_per_person' => $data['incurred_transportation_cost_per_person'] + $data['incurred_food_drink_cost_per_person'] + $data['incurred_ticket_cost_per_person'] + $data['incurred_other_cost_per_person'],
            'incurred_transportation_cost_per_person' => $data['incurred_transportation_cost_per_person'],
            'incurred_food_drink_cost_per_person' => $data['incurred_food_drink_cost_per_person'],
            'incurred_ticket_cost_per_person' => $data['incurred_ticket_cost_per_person'],
            'incurred_other_cost_per_person' => $data['incurred_other_cost_per_person'],
            'suggested_tip' => $data['suggested_tip'],
			'is_experience_per_person' => $data['is_experience_per_person'],
            'state' => $data['state']
        ]);
        return $experience;
    }

	/**
	 * @param Experience $experience
	 * @param User $user
	 */
	public function AddUser(Experience $experience, User $user) {
		$experience->citizen()->associate($user);
    }

	/**
	 * @param Experience $experience
	 * @param Picture $picture
	 */
	public function AddCoverPicture(Experience $experience, Picture $picture) {
		$experience->coverPicture()->associate($picture);
    }

	/**
	 * @param Experience $experience
	 * @param Picture $picture
	 */
	public function AddThumbnailPicture(Experience $experience, Picture $picture) {
		$experience->thumbnailPicture()->associate($picture);
	}

	/**
	 * @param Experience $experience
	 * @param Picture $picture
	 */
	public function AddDescriptionPicture(Experience $experience, Picture $picture) {
		$experience->descriptionPictures()->save($picture);
	}

	/**
	 * @param Experience $experience
	 * @param Area $area
	 */
	public function AddArea(Experience $experience, Area $area) {
		$experience->area()->associate($area);
    }

	/**
	 * @param Experience $experience
	 * @param Partner $partner
	 */
	public function AddPartner(Experience $experience, Partner $partner){
		$experience->partner()->associate($partner);
	}

    /**
     * @param Experience $experience
     * @param Event $event
     */
    public function AddEvent(Experience $experience, Event $event){
		$experience->agenda()->save($event);
	}

	#region edit
	public function GetEdit(Experience $experience, $mainLanguage, &$thumbnail, &$cover, &$descriptionPictures, &$translations, &$descr, &$tags, &$prices) {
		$translationManager = new TranslationManager();

		$thumbnail = $experience->thumbnailPicture;
		$thumbnail = $thumbnail != null ? $thumbnail->source : 'img/app/experiences/no_thumbnail.jpg';

		$cover = $experience->coverPicture;
		$cover = $cover != null ? $cover->source : 'img/app/experiences/no_cover.png';

		$descriptionPictures = $experience->descriptionPictures;

		$languages = $translationManager->Translate($experience->languages, $mainLanguage);
		$translations = $languages->map(function($lang) { return $lang->name; });
		$translations->shift();

		$descriptions = $experience->description()->get();
		$descr = [];
		foreach($descriptions as $description) {
            //dd($experience, $descriptions);
			$language = $translationManager->GetLanguage($description);
			$language = $translationManager->Translate($language, $mainLanguage);
			$descr[$language->name] = $description;
		}

		$tags = $experience->tags;
		$tags = $tags->map(function($tag) { return $tag->name; });

		$prices = [
			'transportation' => $this->getCost($experience->incurred_transportation_cost, $experience->incurred_transportation_cost_per_person),
			'food' => $this->getCost($experience->incurred_food_drink_cost, $experience->incurred_food_drink_cost_per_person),
			'ticket' => $this->getCost($experience->incurred_ticket_cost, $experience->incurred_ticket_cost_per_person),
			'other' => $this->getCost($experience->incurred_other_cost, $experience->incurred_other_cost_per_person),
		];
		$prices['suggested'] = [
			'cost' => $experience->suggested_tip,
			'per_person' => $experience->is_experience_per_person
		];
	}

	private function getCost($total, $perPerson) {
		return [
			'cost' => intval($total) ?: intval($perPerson),
			'per_person' => intval($total) == 0
		];
	}

	public function PostEdit(Experience $experience, User $user, $state, $request) {
		$translationManager = new TranslationManager();
		$descriptionManager = new DescriptionManager();
		$slugManager = new SlugManager();
		$languageManager = new LanguageManager();

		$country = $request->get('country');



		$experience = $this->saveExperience($request->only(['duration', 'min_persons', 'max_persons', 'costs']), $state, $experience);
		$this->saveArea($request->only(['first-city', 'distance']), $country, $experience->area);
		$this->saveMeetingPoint($request->get('address'), $country, $experience->meetingPoint);
		$this->saveTags($request->only(['first-city', 'tags', 'transportation', 'cities']), $experience);

		$translations = $request->get('translations') ?: [];
		array_unshift($translations, $user->mainLanguage->name);

		$descs = $experience->description()->get();
		$slugs = $experience->slug()->get();

		$experience->languages()->detach();
		$translationManager->delete($descs);
		$descriptionManager->delete($descs);
		$translationManager->delete($slugs);
		$slugManager->delete($slugs);

		$descriptions = $request->get('descriptions');
		$descriptions[$translations[0]] = ['title' => $request->get('title'), 'content' => $request->get('content')];

		$reflang = $languageManager->FindOrCreate(['name' => $translations[0]]);
		$refSlug = null;
		$refDescription = null;

		foreach ($translations as $langName) {
			$lang = $this->createTranslation($langName, $reflang, $experience);
			$refSlug = $this->createSlug($lang, $descriptions[$langName]['title'], $experience, $refSlug);
			$refDescription = $this->createDescription($lang, $descriptions[$langName], $experience, $refDescription);
		}

		$path = 'users/user-'.$user->id.'/experiences/experience-'.$experience->id;
		if ($request->has('main')) {
            $pic = $experience->thumbnailPicture;
            if (!is_null($pic)) $this->pictureManager->DeletePicture($pic->source);
            $this->savePicture($experience, $request->input('main')['data'], $path, 'thumbnail_'.time(), 'thumbnail', null, 'AddThumbnailPicture');
        }

		if ($request->has('cover')) {
            $pic = $experience->coverPicture;
            if (!is_null($pic)) $this->pictureManager->DeletePicture($pic->source);
            $this->savePicture($experience, $request->input('cover')['data'], $path, 'cover_'.time(), 'cover', null, 'AddCoverPicture');
        }

		$unsavedIds = $request->input('savedDescriptionPictures');

		if ($unsavedIds != null)
			$unsaved = $experience->descriptionPictures()->whereNotIn('id', $request->input('savedDescriptionPictures'))->delete();

		$descriptionPictures = $request->input('descriptionPictures');
		if($descriptionPictures) {
			foreach ($descriptionPictures as $key => $picture) {
				$uid = time() . '_' . str_random(10);
				$this->savePicture($experience, $picture['data'], $path . '/descriptions', 'description_' . $uid . '_' . $key, 'description', $experience->descriptionPictures, 'AddDescriptionPicture');
			}
		}
		$experience->save();
	}
	#endregion

	#region events
	/**
	 * @param Experience $experience
	 * @return array
	 */
	public function GetEvents(Experience $experience, $offset) {
		$currentEvents = $experience->agenda()->where('date','>',Carbon::now())->where('state','!=','canceled')->get();
		$events = [];

		foreach($currentEvents as $event) {
			//var_dump((new Carbon($event->date))->timestamp);
			$eventDate = (new Carbon($event->date))->timestamp+$offset;
			//var_dump($eventDate);
			$date = $eventDate - $eventDate%86400-$offset;
			if($event->state == 'opened') $events[$date][] = ($eventDate-$offset)*1000;
			else if ($event->state == 'reserved') $events[$date] = null;
			else $events[$date] = false;
		}
		return $events;
	}

	/**
	 * @param Experience $experience
	 * @param $events
	 * @param $offset
	 */
	public function PostEvents(Experience $experience, $events, $offset) {
		$experience->agenda()->where('date','>',Carbon::now())->where('state','=','opened')->orWhere('state','=','closed')->delete();
		foreach ($events as $key => $evt) {
			$day = Carbon::createFromTimeStamp($key);
			$day->addHour($offset);

			if ($evt === false) {
				$event = $this->eventManager->Create([
					'date' => $day,
					'state' => 'closed',
				]);
				$this->eventManager->AddUser($event, $experience->citizen);
				$this->eventManager->AddExperience($event, $experience);
				$event->save();
				continue;
			} else if ($evt === null) continue;
			foreach ($evt as $hour) {
				$date = Carbon::createFromTimeStamp($hour / 1000);
				$event = $this->eventManager->Create([
					'date' => $date,
					'state' => 'opened',
				]);
				$this->eventManager->AddUser($event, $experience->citizen);
				$this->eventManager->AddExperience($event, $experience);
				$event->save();
			}
		}
	}
	#endregion

	#region save Data
	#region saveExperience
	public function SaveExperience($data, $state, Experience $experience) {
		$costs = $data['costs'];



		$data['incurred_cost'] = 0;
		$data['incurred_cost_per_person'] = 0;
		$this->setCosts($costs['transportation'], $data['incurred_transportation_cost'], $data['incurred_transportation_cost_per_person'], $data);
		$this->setCosts($costs['food'], $data['incurred_food_drink_cost'], $data['incurred_food_drink_cost_per_person'], $data);
		$this->setCosts($costs['ticket'], $data['incurred_ticket_cost'], $data['incurred_ticket_cost_per_person'], $data);
		$this->setCosts($costs['other'], $data['incurred_other_cost'], $data['incurred_other_cost_per_person'], $data);

		$data['suggested_tip'] = $costs['tips']['value'];
		$data['is_experience_per_person'] = isset($costs['tips']['per_person']) && $costs['tips']['per_person'] === 'on';
		$data['state'] = $state;

		unset($data['costs']);

		$experience->update($data);
		return $experience;
	}

	private function setCosts($cost, &$global, &$individual, &$data) {
		if(isset($cost['per_person'])) {
			$global = 0;
			$individual = $cost['value'];
			$data['incurred_cost_per_person'] += $individual;
		}
		else {
			$global = $cost['value'];
			$individual = 0;
			$data['incurred_cost'] += $global;
		}
	}
	#endregion

	public function SaveMeetingPoint($data, $country, Address $meetingPoint = null) {
		if($meetingPoint != null) {
			$currentAddress = $meetingPoint;
			$found = Address::find($meetingPoint);
			if($found != $meetingPoint) {
				$meetingPoint->timezone = null;
				$meetingPoint->latitude = null;
				$meetingPoint->longitude = null;
				$meetingPoint->country = $country;
				$meetingPoint->update($data);
				$meetingPoint = $this->addressManager->Complete($meetingPoint);

				if ($meetingPoint == null) {
					$meetingPoint = $currentAddress;
					$meetingPoint->save();
					$errors['address'] = trans('fragment/utils/address.error.invalid');
					return $errors;
				}
				return $meetingPoint;
			}
		}
		else {
			$data['country'] = $country;
			$meetingPoint = $this->addressManager->Create($data);
			$meetingPoint->save();
		}
		return $meetingPoint;
	}

	public function SaveArea($data, $country, Area $area = null) {
		if($area == null) {
			$area = Area::create([]);
			$address = Address::create([]);
			$this->addressManager->AddAddress($address, $area);
		}

		$area->address->update([
			'city' => $data['first-city'],
			'country' => $country
		]);

		$found = $this->addressManager->Complete($area->address);

		if ($found != $area->address) {
			$area->address->latitude = $found->latitude;
			$area->address->longitude = $found->longitude;
			$area->address->timezone = $found->timezone;
		}


		$area->update([
			'range' => $data['distance']
		]);

		return $area;
	}

	/**
	 * @param $data
	 * @param Experience $experience
	 */
	public function SaveTags($data, $experience) {
		$cities = $data['cities'] ?: [];
		$transportations = $data['transportation'] ?: [];
		$tags = $data['tags'] ?: [];

		array_unshift($cities, $data['first-city']);

		$this->tagManager->Clear($experience);

		foreach($cities as $city) {
			$tag = $this->tagManager->Create($city);
			// add city relationship if not set
			$this->tagManager->AddTag($tag, $experience);
		}

		foreach($transportations as $transportation) {
			$tag = $this->tagManager->Create($transportation);
			// add $transportation relationship if not set
			$this->tagManager->AddTag($tag, $experience);
		}

		foreach($tags as $tag) {
			$tag = $this->tagManager->Create($tag);
			$this->tagManager->AddTag($tag, $experience);
		}
	}

	public function CreateTranslation($lang, $refLang, $experience) {
		$language = $this->languageManager->FindOrCreate(['name' => $lang]);
		$this->languageManager->AddLanguage($language, $experience);
        $translation = Translation::where('translatable_type','=',Experience::class)->where('translatable_id','=',$experience->id)->where('translated_reference','=',$refLang->id)->where('language_id','=',$language->id)->first();
		if($translation == null) {
            $translation = $this->translationManager->Create();
            $this->translationManager->AddLanguage($translation, $language);
            $this->translationManager->AddReference($translation, $refLang);
        }
		return $language;
	}

	public function CreateSlug($lang, $title, Experience $experience, $slugRef = null) {
        $slug = Slug::where('sluggable_type','=',Experience::class)->where('sluggable_id','=',$experience->id)->where('reference','=',Str::slug($title))->first();
        if($slug == null)$slug = $this->slugManager->Create([
			'name' => $title,
			'type' => Experience::class
		]);
		if ($slugRef == null) $slugRef = $slug;
        $this->slugManager->AddSlug($slug, $experience);
        $translation = $this->translationManager->Create();
        $this->translationManager->AddLanguage($translation, $lang);
        $this->translationManager->AddReference($translation, $slugRef);
        $this->translationManager->AddTranslation($translation, $slug);
		return $slugRef;
	}

	public function CreateDescription($lang, $data, $experience, $refDescription) {
        $description = Description::where('describable_type','=',Experience::class)->where('describable_id','=',$experience->id)->where('title','=',$data['title'])->where('content','=',$data['content'])->first();
		if($description == null) $description = $this->descriptionManager->Create([
			'title' => $data['title'],
			'content' => $data['content']
		]);
		if ($refDescription == null) $refDescription = $description;
		$this->descriptionManager->AddDescription($description, $experience);
		$translation = $this->translationManager->Create();
		$this->translationManager->AddLanguage($translation, $lang);
		$this->translationManager->AddReference($translation, $refDescription);
		$this->translationManager->AddTranslation($translation, $description);

		return $refDescription;
	}

	public function SavePicture($experience, $pictureData, $path, $name, $album, $destination, $addMethod) {
		if($pictureData) {
			$savePath = $this->pictureManager->SavePicture($name, $path , $pictureData);
			$picture = $this->pictureManager->UpdateOrCreate(['source' => $savePath, 'album' => $album], $destination);
			$this->$addMethod($experience, $picture);
			$this->pictureManager->AddPicture($picture, $experience);
		}
	}
	#endregion
}
