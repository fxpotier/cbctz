<?php namespace CityByCitizen;

use Illuminate\Database\Eloquent\Model;

class FeedbackStat extends Model {
	#region configuration
	/**
	 * The database table used by the model.
	 * @var string
	 */
	protected $table = 'feedback_stats';

	/**
	 * The attributes that are mass assignable.
	 * @var array
	 */
	protected $fillable = ['rate_average','rate_count'];

	/**
	 * The attributes excluded from the model's JSON form.
	 * @var array
	 */
	protected $hidden = [];

	/**
	 * Timestamps management.
	 * @var bool
	 */
	public $timestamps = false;
	#endregion

	#region relationships
	public function feedbackable() { return $this->morphTo(); }
	#endregion
}
