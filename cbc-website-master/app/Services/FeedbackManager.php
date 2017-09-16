<?php
/**
 * Created by PhpStorm.
 * User: Romain
 * Date: 24/05/2015
 * Time: 01:07
 */

namespace CityByCitizen\Services;

use CityByCitizen\Feedback;
use CityByCitizen\FeedbackStat;
use CityByCitizen\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class FeedbackManager {
    /**
     * @param $data
     * @return Feedback
     */
    public function Create($data) {
        $feedback = Feedback::create([
            'value' => $data['value'],
            'content' => $data['content']
        ]);
        return $feedback;
    }

    public function CreateStats($data) {
        $feedback = FeedbackStat::create([
            'rate_average' => $data['rate_average'],
            'rate_count' => 1
        ]);
        return $feedback;
    }



	/**
	 * @param Feedback $rate
	 * @param User $user
	 */
    public function AddUser(Feedback $feedback, User $user) {
        $feedback->author()->associate($user);
    }

    /**
     * @param Feedback $feedback
     * @param Model    $model
     * @param string   $relation
     */
    public function AddFeedback(Feedback $feedback, Model $model, $relation = '') {
        if ($relation === '') $model->feedbacks()->save($feedback);
        else $model->$relation()->save($feedback);
    }

    public function UpdateStats(Feedback $feedback, Model $model, $relation = '') {
        $fbstat = $model->feedbackStats;

        if(!$fbstat) {
            $fbstat = $this->CreateStats([
                'rate_average' => $feedback->value,
            ]);
            $model->feedbackStats()->save($fbstat);
        } else {
            $fbstat->rate_average = (($fbstat->rate_average * $fbstat->rate_count) + $feedback->value) / ($fbstat->rate_count + 1);;
            $fbstat->rate_count++;

        }
        $fbstat->save();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function Validate($data) {
        $validator = Validator::make($data, [
            'value' => 'numeric | min : 1 | max:5',
        ]);

        if (!$validator->fails()) return true;
        return $validator;
    }
}