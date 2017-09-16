<?php namespace CityByCitizen;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model {
	#region configuration
	/**
	 * The database table used by the model.
	 * @var string
	 */
	protected $table = 'collections';

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
	public function tags() { return $this->belongsToMany('\CityByCitizen\Tag'); }
	public function pictograms() { return $this->morphMany('\CityByCitizen\Pictogram', 'pictogramable'); }
	public function slugs() { return $this->morphMany('\CityByCitizen\Slug', 'sluggable'); }
	#endregion
}
