<?php namespace CityByCitizen;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed alias
 */
class Language extends Model {
	#region configuration
	/**
	 * The database table used by the model.
	 * @var string
	 */
	protected $table = 'languages';

	/**
	 * The attributes that are mass assignable.
	 * @var array
	 */
	protected $fillable = ['name'];

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
	public function specialRequest() { return $this->belongsToMany('\CityByCitizen\SpecialRequest'); }
	public function usersMain() { return $this->hasMany('\CityByCitizen\User', 'main_language_id'); }
	public function usersDisplay() { return $this->hasMany('\CityByCitizen\User', 'display_language_id'); }
	public function speakers() { return $this->belongsToMany('\CityByCitizen\User'); }
	public function translation() { return $this->morphMany('\CityByCitizen\Translation', 'translatable'); }
	#endregion
}