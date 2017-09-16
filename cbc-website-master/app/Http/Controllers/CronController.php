<?php
/**
 * Created by PhpStorm.
 * User: Romain
 * Date: 10/07/2015
 * Time: 18:04
 */

namespace CityByCitizen\Http\Controllers;



use Carbon\Carbon;
use CityByCitizen\Payment;
use CityByCitizen\Services\AccountManager;
use CityByCitizen\Services\EventManager;
use CityByCitizen\Services\ExperienceManager;
use CityByCitizen\Services\MangoPay;
use CityByCitizen\Services\PaymentManager;
use CityByCitizen\Services\SlugManager;
use CityByCitizen\Services\TravelManager;
use CityByCitizen\Travel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use ThunderArrow\MangoPay\Money;
use ThunderArrow\MangoPay\Requests\CreateBankwirePayout;
use ThunderArrow\MangoPay\Requests\CreateDirectPreauthorizedPayin;

class CronController extends Controller {

    function __construct(Request $request, TravelManager $travelManager, SlugManager $slugManager,
                         AccountManager $accountManager, PaymentManager $paymentManager,
                         ExperienceManager $experienceManager, EventManager $eventManager) {

        $this->travelManager = $travelManager;
        $this->slugManager = $slugManager;
        $this->accountManager = $accountManager;
        $this->paymentManager = $paymentManager;
        $this->experienceManager = $experienceManager;
        $this->eventManager = $eventManager;
    }

    public function getIndex(MangoPay $mangoPay) {
        $travels = Travel::where('booked_at', '<', Carbon::now())->where('state','=','booked')->get();
        foreach($travels as $travel)
        {
            $this->paymentManager->chargeExperience($travel,$mangoPay);
        }

        $outdate = Carbon::now();
        $outdate->addDay(-7);
        $travels = Travel::where('booked_at', '<',$outdate )->where('state','=','asked')->get();

        foreach($travels as $travel)
        {
            $travel->state = 'denied';
            $travel->payment_auth_id = null;
            $travel->save();
        }

    }
}