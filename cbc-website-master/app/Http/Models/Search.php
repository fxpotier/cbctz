<?php namespace CityByCitizen;

use Illuminate\Database\Eloquent\Model;

class Search extends Model {
	#region configuration
	/**
	 * The database table used by the model.
	 * @var string
	 */
	protected $table = 'searches';

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
	public function account() { return $this->belongsTo('\CityByCitizen\Account'); }
	public function results() { return $this->hasMany('\CityByCitizen\SearchResult'); }
	#endregion
}
