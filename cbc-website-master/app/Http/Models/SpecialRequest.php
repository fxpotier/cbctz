<?php namespace CityByCitizen;

use Illuminate\Database\Eloquent\Model;

class SpecialRequest extends Model {
	#region configuration
	/**
	 * The database table used by the model.
	 * @var string
	 */
	protected $table = 'special_requests';

	/**
	 * The attributes that are mass assignable.
	 * @var array
	 */
	protected $fillable = [];

	/**
	 * The attributes excluded from the model's JSON form.
	 * @var array
	 */
	protected $hidden = [];

	/**
	 * Timestamps management.
	 * @var bool
	 */
	public $timestamps = true;
	#endregion

	#region relationships
	public function traveler() { return $this->belongsTo('\CityByCitizen\User'); }
	public function languages() { return $this->belongsToMany('\CityByCitizen\Language'); }
	public function citizens() { return $this->belongsToMany('\CityByCitizen\User', 'user_special_request', 'special_request_id', 'user_id'); }
	public function meetingPoint() { return $this->morphMany('\CityByCitizen\Address', 'addressable'); }
	public function description() { return $this->morphMany('\CityByCitizen\Description', 'describable'); }
	#endregion
}
