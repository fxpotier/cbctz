<?php
/**
 * Created by PhpStorm.
 * User: Romain
 * Date: 23/05/2015
 * Time: 15:38
 */

namespace CityByCitizen\Seeds;

use Carbon\Carbon;
use CityByCitizen\Event;
use CityByCitizen\Experience;
use CityByCitizen\Services\CommentManager;
use CityByCitizen\Services\FeedbackManager;
use CityByCitizen\Services\TravelManager;
use CityByCitizen\User;
use Illuminate\Database\Seeder;

class TravelsSeeder extends Seeder {
	#region attributes
	/**
	 * @var CommentManager
	 */
    private $commentManager;
	/**
	 * @var TravelManager
	 */
    private $travelManager;
	/**
	 * @var FeedbackManager
	 */
    private $rateManager;
	#endregion

    function __construct (CommentManager $commentManager, TravelManager $travelManager, FeedbackManager $rateManager) {
        $this->travelManager = $travelManager;
        $this->commentManager = $commentManager;
        $this->rateManager = $rateManager;
    }

    public function run() {
        $travelData = [
            'commented' => true,
            'rated' => true,
            'booked_at' => Carbon::now(),
            'state' => 'BOOKED'
        ];

        $citizen = User::where('firstname', '=', 'Marc')->where('lastname', '=', 'Gavanier')->first();
        $traveler = User::where('firstname', '=', 'Romain')->where('lastname', '=', 'Cambonie')->first();
        $event =   Event::where('date', 'like', '%2015-07-06%')->first();
        $experience = Experience::where('id','=', $event->experience_id)->first();

        #region travel comment
        $comment = $this->commentManager->Create([
            'content' => 'Marc et Nicolas sont les meilleurs associées du monde ! Je ne bosserai pour aucune autre boîte au monde avec une équipe pareille ! On s\'engueule dans la bonne humeur générale. Vers l\infini et l\'au dela ! Thunder Arrow à la conquête du monde ! :D'
        ]);
        #endregion

        #region travel rate
        $rate = $this->rateManager->Create([
            'value' => 5
        ]);
        #endregion

        $this->CreateTravel($travelData, $citizen, $traveler, $event, $experience, $comment, $rate);
    }

    public function CreateTravel($travelData, $citizen, $traveler, $event, $experience, $comment, $rate) {
        $travel = $this->travelManager->Create($travelData);
        $this->travelManager->AddCitizen($travel, $citizen);
        $this->travelManager->AddTraveler($travel, $traveler);
        $this->travelManager->AddEvent($travel, $event);
        $this->travelManager->AddExperience($travel, $experience);
        $travel->save();

        $experience = $travel->experience()->getResults();
        $this->commentManager->AddUser($comment, $traveler);
        $this->commentManager->AddComment($comment, $experience, 'comments');

        $this->rateManager->AddUser($rate, $traveler);
        $this->rateManager->AddRate($rate,$experience);
        return $travel;
    }

}