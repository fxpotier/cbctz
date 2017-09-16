<?php namespace CityByCitizen;

use Illuminate\Database\Eloquent\Model;

class Area extends Model {
	#region configuration
	/**
	 * The database table used by the model.
	 * @var string
	 */
	protected $table = 'areas';

	/**
	 * The attributes that are mass assignable.
	 * @var array
	 */
	protected $fillable = ['range'];

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
	public function address() { return $this->morphOne('\CityByCitizen\Address', 'addressable'); }
	#endregion
}
