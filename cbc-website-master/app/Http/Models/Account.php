<?php namespace CityByCitizen;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class Account extends Model implements AuthenticatableContract {
	use Authenticatable;

	#region configuration
	/**
	 * The database table used by the model.
	 * @var string
	 */
	protected $table = 'accounts';

	/**
	 * The attributes that are mass assignable.
	 * @var array
	 */
	protected $fillable = ['mail', 'password'];

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
	public function user() { return $this->hasOne('\CityByCitizen\User'); }
	public function searches() { return $this->hasMany('\CityByCitizen\Search'); }
	public function role() { return $this->belongsTo('\CityByCitizen\Role'); }
	public function rights() { return $this->hasManyThrough('\CityByCitizen\Right', '\CityByCitizen\Role'); }
	#endregion
}
