<?php namespace CityByCitizen;

use Illuminate\Database\Eloquent\Model;

class Role extends Model {
	#region configuration
	/**
	 * The database table used by the model.
	 * @var string
	 */
	protected $table = 'roles';

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
	public function accounts() { return $this->belongsToMany('\CityByCitizen\Account'); }
	public function rights() { return $this->belongsToMany('\CityByCitizen\Right'); }
	#endregion
}
