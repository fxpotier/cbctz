<?php namespace CityByCitizen;

use Illuminate\Database\Eloquent\Model;

class Travel extends Model {
	#region configuration
	/**
	 * The database table used by the model.
	 * @var string
	 */
	protected $table = 'travels';

	/**
	 * The attributes that are mass assignable.
	 * @var array
	 */
	protected $fillable = ['commented','rated','persons','booked_at','state','payment_preauth_id'];

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
	public function feedback() { return $this->morphOne('\CityByCitizen\Feedback', 'feedbackable'); }
	public function traveler() { return $this->belongsTo('\CityByCitizen\User', 'traveler_id'); }
	public function citizen() { return $this->belongsTo('\CityByCitizen\User', 'citizen_id'); }
	public function experience() { return $this->belongsTo('\CityByCitizen\Experience'); }
	public function event() { return $this->belongsTo('\CityByCitizen\Event'); }
	#endregion
}
