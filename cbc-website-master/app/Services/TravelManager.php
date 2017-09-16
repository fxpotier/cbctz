<?php
/**
 * Created by PhpStorm.
 * User: Marc
 * Date: 22/05/2015
 * Time: 17:09
 */

namespace CityByCitizen\Services;

use CityByCitizen\Comment;
use CityByCitizen\Event;
use CityByCitizen\Experience;
use CityByCitizen\Feedback;
use CityByCitizen\Travel;
use CityByCitizen\User;

class TravelManager {
	/**
	 * @param $data
	 * @return Travel
	 */
	public function Create($data) {
		$travel = Travel::create([
			'feedback' => $data['feedback'],
			'signal' => $data['signal'],
            'persons' => $data['persons'],
			'booked_at' => $data['booked_at'],
			'state' => $data['state'],
            'payment_preauth_id' =>  $data['payment_preauth_id']
		]);
		return $travel;
	}

	/**
	 * @param Travel $travel
	 * @param Event $event
	 */
	public function AddEvent(Travel $travel, Event $event) {
		$travel->event()->associate($event);
	}

	/**
	 * @param Travel $travel
	 * @param Experience $experience
	 */
	public function AddExperience(Travel $travel, Experience $experience) {
		$travel->experience()->associate($experience);
	}

	/**
	 * @param Travel $travel
	 * @param User $user
	 */
	public function AddCitizen(Travel $travel, User $user) {
		$travel->citizen()->associate($user);
	}

	/**
	 * @param Travel $travel
	 * @param User $user
	 */
	public function AddTraveler(Travel $travel, User $user) {
		$travel->traveler()->associate($user);
	}

    public function AddComment(Travel $travel, Comment $comment, $role) {

        if($role == 'traveler') {
            $travel->feedback_state += 1;
            //$travel->experience()->getResults()->comments()->save($comment);
        } elseif ($role == 'citizen') {
            $travel->feedback_state += 2;
            //$travel->traveler()->getResults()->receivedComments()->save($comment);
        }
    }

    public function AddRate(Travel $travel, Feedback $rate, $role) {
        if($role == 'traveler')     $travel->experience()->getResults()->rates()->save($rate);
        elseif ($role == 'citizen') $travel->traveler()->getResults()->receivedRates()->save($rate);
    }

    public function AddSignal(Travel $travel, Feedback $rate, $role) {
        if($role == 'traveler') {
            $travel->signal += 1;
            //$travel->experience()->getResults()->comments()->save($comment);
        } elseif ($role == 'citizen') {
            $travel->signal += 2;
            //$travel->traveler()->getResults()->receivedComments()->save($comment);
        }
    }

    public function SetState(Travel $travel, $state) {
        if($state == 'denied' || $state == 'canceled')
        $travel->event->state ='canceled';
        $travel->event->save();
        $travel->state = $state;
        $travel->save();
    }
} 