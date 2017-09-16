<?php
/**
 * Created by PhpStorm.
 * User: Marc
 * Date: 11/06/2015
 * Time: 15:15
 */

namespace CityByCitizen\Seeds;

use CityByCitizen\Description;
use CityByCitizen\Experience;
use CityByCitizen\Services\EventManager;
use CityByCitizen\Services\SlugManager;
use CityByCitizen\Services\UserManager;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class EventsSeeder extends Seeder {
	#region attributes
	/**
	 * @var EventsSeeder
	 */
	private $eventManager;
    /**
     * @var UserManager
     */
    private $userManager;
    /**
     * @var SlugManager
     */
    private $slugManager;
    #endregion

	#region constructor
	function __construct (EventManager $eventManager, UserManager $userManager, SlugManager $slugManager) {
        $this->eventManager = $eventManager;
        $this->userManager = $userManager;
        $this->slugManager = $slugManager;
    }
	#endregion


    public function run() {
        $dataToSeed = include 'data/events.php';
        $this->Create(collect($dataToSeed));
    }

	/**
	 * @param $dataToSeed
	 * @return array|Description
	 */
	public function Create($dataToSeed) {
        if($dataToSeed instanceof Collection) {
            $events = [];
            foreach ($dataToSeed as $event) $events[] = $this->Create($event);
            return $events;
        }
        else {
            $event = $this->eventManager->Create($dataToSeed['data']);
            $this->eventManager->AddUser($event,$this->userManager->GetByMail($dataToSeed['userMail']));
            $this->eventManager->AddExperience($event, $this->slugManager->GetBySlug($dataToSeed['experienceSlug'],Experience::class));
            $event->save();
            return $event;
        }
	}
} 