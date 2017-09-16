<?php namespace CityByCitizen;

use Illuminate\Database\Eloquent\Model;

class Event extends Model {
	#region configuration
	/**
	 * The database table used by the model.
	 * @var string
	 */
	protected $table = 'events';

	/**
	 * The attributes that are mass assignable.
	 * @var array
	 */
	protected $fillable = ['date', 'state'];

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
	public function user() { return $this->belongsTo('\CityByCitizen\User'); }
	public function experience() { return $this->belongsTo('\CityByCitizen\Experience'); }
	public function travel() { return $this->belongsTo('\CityByCitizen\Travel'); }
	#endregion
}
