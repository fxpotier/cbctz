<?php
/**
 * Created by PhpStorm.
 * User: Marc
 * Date: 15/06/2015
 * Time: 11:52
 */

namespace CityByCitizen\Http\Controllers;


use Carbon\Carbon;
use CityByCitizen\Event;
use CityByCitizen\Experience;
use CityByCitizen\Language;
use CityByCitizen\Payment;
use CityByCitizen\Services\AccountManager;
use CityByCitizen\Services\AddressManager;
use CityByCitizen\Services\CommentManager;
use CityByCitizen\Services\DescriptionManager;
use CityByCitizen\Services\EventManager;
use CityByCitizen\Services\ExperienceManager;
use CityByCitizen\Services\LanguageManager;
use CityByCitizen\Services\MangoPay;
use CityByCitizen\Services\PaymentManager;
use CityByCitizen\Services\FeedbackManager;
use CityByCitizen\Services\SlugManager;
use CityByCitizen\Services\TokenManager;
use CityByCitizen\Services\TranslationManager;
use CityByCitizen\Services\TravelManager;
use CityByCitizen\Travel;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use PhpParser\Node\Expr\Cast\Array_;
use ThunderArrow\MangoPay\Money;
use ThunderArrow\MangoPay\Requests\CreateDirectPreauthorizedPayin;
use ThunderArrow\Validation\Services\SuperValidator;

class BookingController extends Controller {
	#region fields
    /**
     * @var TravelManager
     */
    private $travelManager;

    /**
     * @var SlugManager
     */
    private $slugManager;
    /**
     * @var AccountManager
     */
    private $accountManager;
    /**
     * @var TokenManager
     */
    private $tokenManager;
    /**
     * @var Request
     */
    private $request;
    /**
     * @var PaymentManager
     */
    private $paymentManager;
    /**
     * @var ExperienceManager
     */
    private $experienceManager;
    /**
     * @var EventManager
     */
    private $eventManager;
    /**
     * @var CommentManager
     */
    private $commentManager;
    /**
     * @var FeedbackManager
     */
    private $feedbackManager;
    /**
     * @var AddressManager
     */
    private $addressManager;
    /**
     * @var LanguageManager
     */
    private $languageManager;
    /**
     * @var TranslationManager
     */
    private $translationManager;
    /**
     * @var DescriptionManager
     */
    private $descriptionManager;
    #endregion

	#region constructor
    /**
     * @param Request $request
     * @param TravelManager $travelManager
     * @param SlugManager $slugManager
     * @param AccountManager $accountManager
     * @param TokenManager $tokenManager
     * @param PaymentManager $paymentManager
     * @param ExperienceManager $experienceManager
     */
    function __construct(Request $request, TravelManager $travelManager, SlugManager $slugManager,
                         AccountManager $accountManager, TokenManager $tokenManager, PaymentManager $paymentManager,
                         ExperienceManager $experienceManager, EventManager $eventManager,
                         FeedbackManager $feedbackManager, AddressManager $addressManager, LanguageManager $languageManager,
                         TranslationManager $translationManager, DescriptionManager $descriptionManager) {

        $this->middleware('auth', ['except' => ['getBookingRegister']]);
        $this->travelManager = $travelManager;
        $this->slugManager = $slugManager;
        $this->accountManager = $accountManager;
        $this->tokenManager = $tokenManager;
        $this->paymentManager = $paymentManager;
        $this->experienceManager = $experienceManager;
        $this->eventManager = $eventManager;
        $this->feedbackManager = $feedbackManager;
        $this->addressManager = $addressManager;
        $this->languageManager = $languageManager;
        $this->translationManager = $translationManager;
        $this->descriptionManager = $descriptionManager;

		$startPathInfo = parse_url(action('BookingController@getPay'));
        $getStartUri = substr($startPathInfo['path'].'/*', 1);

        if ($request->is($getStartUri)) {
			$slug = str_replace($startPathInfo['path'].'/', '', $request->getPathInfo());
        	session(['reservation' => [
				'date' => Carbon::createFromTimeStamp($request->get('date')/1000),
				'people' => $request->get('people'),
                'offset' => $request->get('offset')
			]]);
            Session::flash('register_action', action('BookingController@getBookingRegister', ['slug' => $slug]));
          }
    }
	#endregion

	public function getIndex() {
		$user = Auth::user()->user;

        //Update travels regarding time
        $travelsArray[] = $user->travelsAsTraveler()->get()
            ->groupBy('state');

        $travelsArray[] = $user->travelsAsCitizen()->get()
            ->groupBy('state');

        foreach($travelsArray as $travels) {
            foreach($travels as $state) {
                foreach ($state as $travel) {
                    $date = new Carbon($travel->event->date);
                    $date->setTimezone(new DateTimeZone(timezone_name_from_abbr('', $travel->experience->meetingPoint->timezone, 0)));
                    $travel->event->date = $date;
                    $exp = $travel->experience;
                    $user = Auth::user()->user;
                    $expLanguages = $exp->languages()->get()->groupBy('alias')->keys()->all();
                    $var = $user->languages()->get()->groupBy('alias')->keys()->all();
                    array_unshift($var, $user->mainLanguage->alias);
                    $language = array_intersect($var, $expLanguages);
                    if(!empty($language)) $language = array_shift($language);
                    else if(in_array($user->displayLanguage->alias, $expLanguages)) $language = $user->displayLanguage->alias;
                    else $language = $exp->citizen->mainLanguage->alias;

                    $exp->description = $this->translationManager->Translate($exp->description,$language);

                    $slugByAlias = [];
                    foreach($exp->slug as $sl)
                        $slugByAlias[$this->translationManager->GetLanguage($sl)->alias] = $sl->name;

                    $exp->slugByAlias = $slugByAlias;

                    $slugArray = $exp->slug;
                    foreach ($slugArray as $slug) {
                        if($slug->translation[0]->language->alias == $language) $exp->slugName = $slug->name;
                    }
                }
            }
        }

        $asked = array_shift($travelsArray);
        $received = array_shift($travelsArray);

		return view('booking.index')
			->withAsked($asked)
			->withReceived($received);
	}

    public function getBookingRegister($slug, $suffix = null) {

        $exp = $this->slugManager->GetBySlug($slug, Experience::class);
        if($suffix) $language = Language::where('alias','=',$suffix)->first()->alias;
        else if (!Auth::check()) {
            $language = $this->translationManager->GetLanguage($this->slugManager->FindSlug($slug, Experience::class))->alias;
        }
        $exp->description = $this->translationManager->Translate($exp->description,$language);

        $reservation = session('reservation');
        if( $reservation['date'] < Carbon::now()) return Redirect::back();
        $reservation['date']->setTimezone(new DateTimeZone(timezone_name_from_abbr('', $this->slugManager->GetBySlug($slug, Experience::class)->meetingPoint->timezone, 0)));


        return view('booking.guest')
			->withExperience($exp)
            ->withSlug($slug)
			->withReservation(session('reservation'));
    }

    /*public function postSignUpByBooking(Request $request) {
        $data = $request->only('firstname', 'lastname', 'mail', 'password', 'password_confirmation');
        $validate = $this->accountManager->Validate($data);
        if ($validate !== true) return view('auth.sign-up')->withErrors($validate)->withInput($request->except('password', 'password_confirmation'));

        $account = $this->accountManager->Create($data);
        $token = $this->tokenManager->CreateActivation($account);
        $this->accountManager->SendActivationMail($token, $request->input('firstname'));
        //return view('common.message')->withMessage(trans('auth.signup.success', ['mail' => $account->mail]))->withType('success');
    }*/

    public function getPay($slug) {
        $exp = $this->slugManager->GetBySlug($slug, Experience::class);
        $user = Auth::user()->user;
        $expLanguages = $exp->languages()->get()->groupBy('alias')->keys()->all();
        $var = $user->languages()->get()->groupBy('alias')->keys()->all();
        array_unshift($var, $user->mainLanguage->alias);
        $language = array_intersect($var, $expLanguages);
        if(!empty($language)) $language = array_shift($language);
        else if(in_array($user->displayLanguage->alias, $expLanguages)) $language = $user->displayLanguage->alias;
        else $language = $exp->citizen->mainLanguage->alias;
        $exp->description = $this->translationManager->Translate($exp->description,$language);
        $reservation = session('reservation');
        $utc = new Carbon($reservation['date']);
        if($utc < Carbon::now()) return Redirect::back();
        $reservation['date']->setTimezone(new DateTimeZone(timezone_name_from_abbr('', $this->slugManager->GetBySlug($slug, Experience::class)->meetingPoint->timezone, 0)));
        return view('booking.pay')
            ->withExperience($exp)
            ->withUser(Auth::user()->user->load('address'))
            ->withReservation($reservation)
            ->withUtc($utc)
            ->withSlug($slug);
    }

    public  function postPayment($slug, Request $request, MangoPay $mangoPay) {
        //Validation
        $payment =  $request->only('cardNumber','cardExpirationDate','cardCvx');
        $profile = $request->only(['firstname', 'lastname', 'phone', 'gender', 'date', 'nationality']);
        $address = $request->input('address');
        $validator = SuperValidator::make('Profile', $profile)->validate('Address', $address)->validate('Payment', $payment);
        if ($validator->fails()) return Redirect::back()->withErrors($validator->errors());

        // Update user profile Identity and Adress
        $account = Auth::user();
        $this->slugManager->Update($account->user, $request->input('firstname') . '-' . $request->input('lastname')[0]);
        $this->accountManager->UpdateProfile($account, $request->only(['firstname', 'lastname', 'phone', 'gender', 'date', 'nationality']));
        $address = $this->addressManager->UpdateOrCreateAddress($account->user->address, $request->input('address'));
        $account->user->address()->save($address);

        //Payment process
        $experience = $this->slugManager->GetBySlug($slug, Experience::class);

        if($experience->citizen->account->mail == Auth::user()->user->account->mail) {
            $errors['user'] = trans('view/booking/pay.errors.same-user');
            return Redirect::back()->withMango($errors);
        }

        $details = [
            'people' =>  $request->input('people'),
            'date'=>  Carbon::parse($request->input('booking_date')),
        ];


        $experience = $this->slugManager->GetBySlug($slug, Experience::class);

        $event = $this->ValidateReservation($experience, $details['date'], $details['people']);
        if(isset($event['reservation'])) return Redirect::back()->withMango($event);
        $data = $this->paymentManager->RegisterAndPreAuthoriseCard(
            $this->paymentManager->ComputePrice($experience, $details['people']),$request,$mangoPay
        );

        if(!$data instanceof \stdClass) return Redirect::back()->withMango($data);
        $state = $event->state == 'opened'?'booked':'asked';
        $event->state = 'reserved';
        $event->save();

        $travel = $this->travelManager->Create([
            'feedback' => 0,
            'signal' => 0,
            'persons' => $details['people'],
            'booked_at' => $details['date'],
            'state' => $state,
            'payment_preauth_id' =>  $data->Id
        ]);
        $this->travelManager->AddExperience($travel,$experience);
        $this->travelManager->AddEvent($travel,$event);
        $this->travelManager->AddCitizen($travel,$experience->citizen);
        $this->travelManager->AddTraveler($travel,Auth::user()->user);
        $travel->save();

        if($state == 'booked') {
            $this->SendBookingMails($travel,'auto');
        } else $this->SendBookingMails($travel,$state);

        return Redirect::action('BookingController@getIndex');
    }

    public function postState($id, $state, $role, MangoPay $mangoPay) {
        $travel = Travel::find($id);
        $date = new Carbon($travel->booked_at);
        $time_diff = $date->diffInHours(null,false);

        Log::info('state '.$state);

        if($time_diff > 0) {
            if($travel->state == 'booked') {
                $this->paymentManager->chargeExperience($travel,$mangoPay);
            } else if ($travel->state == 'asked') {
                $state = 'denied';
            }
        } else if($state == 'canceled') {
           if ($time_diff > -24) {
                $this->paymentManager->chargeExperience($travel,$mangoPay);
            } else if ($time_diff > -48) {
                $citizen = Payment::where('user_id','=',$travel->citizen->id)->first();
                //Charge the PreAuthorized amount
                $req = new CreateDirectPreauthorizedPayin($mangoPay);
                $req->AuthorId =  Payment::where('user_id','=',$travel->traveler->id)->first()->user_mango_id;
                $req->DebitedFunds =  new Money('EUR',$travel->persons*200);
                $req->Fees = new Money('EUR', $travel->persons*200);
                $req->CreditedUserId = $citizen->user_mango_id;
                $req->CreditedWalletId = $citizen->wallet_id;
                $req->PreauthorizationId = $travel->payment_preauth_id;
                $reqResult = $req->execute();
            }
        }

        $this->travelManager->setState($travel, $state);
        $this->SendBookingMails($travel,$travel->state);

    }

	public function postSignal($id, $role) {

	}

	public function postFeedback(Request $request) {
        $travel = Travel::find($request->input('id'));

        $feedback = $this->feedbackManager->Create(
            [
                'value' => $request->input('rate'),
                'content' => $request->input('comment')
            ]
        );
        $this->feedbackManager->AddUser($feedback,Auth::user()->user);

        if($request->input('role') == 'traveler') {
            $travel->feedback_state |= 1;
            $this->feedbackManager->AddFeedback($feedback,$travel,'feedback');
            $this->feedbackManager->UpdateStats($feedback,$travel->experience);
            $this->feedbackManager->UpdateStats($feedback,$travel->citizen);
        } else {
            $travel->feedback_state |= 2;
            $this->feedbackManager->AddFeedback($feedback,$travel->traveler,'feedbacksReceived');
            $this->feedbackManager->UpdateStats($feedback,$travel->traveler);
        }
        $travel->save();
        return Redirect::action('BookingController@getIndex');
	}


    public function ValidateReservation($experience, $booked_at,$people) {
        if($experience->min_persons > $people || $experience->max_persons < $people ) abort(403, 'Unauthorized action, number of people of the experience is incorrect.');
        $event = $experience->agenda()->where('date', '=', $booked_at)->first();
        if(!$event) {
            $event = $this->eventManager->Create([
                'date' => $booked_at,
                'state' => 'reserved',
            ]);
            $this->eventManager->AddUser($event,$experience->citizen);
            $this->eventManager->AddExperience($event,$experience);
        } else {
            if ($event->state == 'reserved') {
                $errors['reservation'] = "This date and time are already reserved";
                return $errors;
            }
            if ($event->state == 'closed') {
                $errors['reservation'] = "This date and time are not opened to reservation";
                return $errors;
            }
        }
        return $event;
    }

    private function SendBookingMails($travel, $state) {
        $timestamp = new Carbon($travel->event->date);
        $timestamp->setTimezone(new DateTimeZone(timezone_name_from_abbr('', $travel->experience->meetingPoint->timezone, 0)));
        $citizen = $travel->citizen;
        $citizen['mail'] = $travel->citizen->account->mail;
        $traveler =  $travel->traveler;
        $traveler['mail'] = $travel->traveler->account->mail;

        $date = explode('-',$timestamp->format('d-F-Y-H:i'));
        $locale = App::getLocale();
        App::setLocale($citizen->mainLanguage->alias);
        $description = $this->translationManager->Translate($travel->experience->description,$citizen->mainLanguage);
        $data = [
            'citizen' => $citizen,
            'traveler' => $traveler,
            'experience' => $description->title,
            'date' => $date[0].' '.trans('utils/date.months.'.strtolower($date[1])).' '.$date[2],
            'time' => $date[3],
            'price' => $this->paymentManager->ComputePrice($travel->experience,$travel->persons)
        ];

        Mail::send('emails/citizen/booking-'.$state, ['data' => $data], function($mail) use($data, $state, $travel) {
            $mail->from(config('cbc.mail-notification'), config('cbc.name'))
                ->to($travel->citizen->account->mail)
                ->subject(trans('view/booking/emails.subject.citizen.'.$state));
        });

        App::setLocale($traveler->mainLanguage->alias);
        $description = $this->translationManager->Translate($travel->experience->description,$traveler->mainLanguage);
        $data['date'] = $date[0].' '.trans('utils/date.months.'.strtolower($date[1])).' '.$date[2];
        $data['time'] = $date[3];
        $data['experience'] = $description->title;

        Mail::send('emails/traveler/booking-'.$state, ['data' => $data], function($mail) use($data, $state, $travel) {
            $mail->from(config('cbc.mail-notification'), config('cbc.name'))
                ->to($travel->traveler->account->mail)
                ->subject(trans('view/booking/emails.subject.traveler.'.$state));
        });

        App::setLocale($locale);
    }
}