<?php
/**
 * Created by PhpStorm.
 * User: Marc
 * Date: 22/05/2015
 * Time: 16:40
 */

namespace CityByCitizen\Services;

use Carbon\Carbon;
use CityByCitizen\Event;
use CityByCitizen\Experience;
use CityByCitizen\Slug;
use CityByCitizen\User;
use DateTime;

class EventManager {
	/**
	 * @param $data
	 * @return Event
	 */
	public function Create($data) {
		$event = new Event($data);
		return $event;
	}

	/**
	 * @param Event $event
	 * @param User $user
	 */
	public function AddUser(Event $event, User $user) {
		$event->user()->associate($user);
	}

	/**
	 * @param Event $event
	 * @param Experience $experience
	 */
	public function AddExperience(Event $event, Experience $experience) {
		$event->experience()->associate($experience);
	}

    public function getEvents($experience,$year) {
        $expId = Slug::where('name', '=', $experience)->where('sluggable_type', '=', Experience::class)->first()->sluggable()->first()->id;
        $events = Event::where('experience_id', '=', $expId)->where('date','>',Carbon::now())->where('date', 'like', '%'.$year.'%')->get();

        $never = [];
        $auto = [];

        foreach( $events as $event) {
			$dt = DateTime::createFromFormat('Y-m-d G:i:s', $event->date);
			$date = Carbon::instance($dt);
			if($event->state == "opened") $auto[$date->month." ".$date->day." ".$date->year][] = $date->toW3cString();
			else $never[] = ($date->month." ".$date->day." ".$date->year);
        }

        $result['auto'] = $auto;
        $result['never'] = $never;

        return $result;

    }
} 