<?php namespace CityByCitizen;

use Illuminate\Database\Eloquent\Model;

class Address extends Model {
	#region configuration
	/**
	 * The database table used by the model.
	 * @var string
	 */
	protected $table = 'addresses';

	/**
	 * The attributes that are mass assignable.
	 * @var array
	 */
	protected $fillable = ['street', 'zipcode', 'latitude', 'longitude', 'city', 'country', 'timezone'];

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
	public function addressable() { return $this->morphTo(); }
	#endregion
}
