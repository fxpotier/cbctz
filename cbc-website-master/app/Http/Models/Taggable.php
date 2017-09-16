<?php namespace CityByCitizen;

use Illuminate\Database\Eloquent\Model;

class Taggable extends Model {
	#region configuration
	/**
	 * The database table used by the model.
	 * @var string
	 */
	protected $table = 'taggables';

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
}
