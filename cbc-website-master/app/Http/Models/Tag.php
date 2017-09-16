<?php namespace CityByCitizen;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model {
	#region configuration
	/**
	 * The database table used by the model.
	 * @var string
	 */
	protected $table = 'tags';

	/**
	 * The attributes that are mass assignable.
	 * @var array
	 */
	protected $fillable = ['name', 'slug'];

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
	public function collections() { return $this->belongsToMany('\CityByCitizen\Collection'); }
	public function pictograms() { return $this->morphMany('\CityByCitizen\Pictogram', 'pictogramable'); }
	public function translation() { return $this->morphMany('\CityByCitizen\Translation', 'translatable'); }
	public function users() { return $this->morphedByMany('\CityByCitizen\User', 'taggable'); }
	public function experiences() { return $this->morphedByMany('\CityByCitizen\Experience', 'taggable'); }
	public function articles() { return $this->morphedByMany('\CityByCitizen\Article', 'taggable'); }
	#endregion
}
