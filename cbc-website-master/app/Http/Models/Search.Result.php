<?php namespace CityByCitizen;

use Illuminate\Database\Eloquent\Model;

class SearchResult extends Model {
	#region configuration
	/**
	 * The database table used by the model.
	 * @var string
	 */
	protected $table = 'search_results';

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
	public function search() { return $this->belongsTo('\CityByCitizen\Search'); }
	public function result() { return $this->belongsTo('\CityByCitizen\Slug'); }

	#endregion
}
