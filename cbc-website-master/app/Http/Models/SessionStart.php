<?php namespace CityByCitizen;

use Illuminate\Database\Eloquent\Model;

class SessionStart extends Model {
	#region configuration
	/**
	 * The database table used by the model.
	 * @var string
	 */
	protected $table = 'session_starts';

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
	public $timestamps = false;
	#endregion

	#region relationships
	public function period() { return $this->belongsTo('\CityByCitizen\Period'); }
	#endregion
}
