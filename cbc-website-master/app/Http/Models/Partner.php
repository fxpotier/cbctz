<?php namespace CityByCitizen;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model {
	#region configuration
	/**
	 * The database table used by the model.
	 * @var string
	 */
	protected $table = 'partners';

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
	public function experiences() { return $this->hasMany('\CityByCitizen\Experience'); }
	public function picture() { return $this->belongsTo('\CityByCitizen\Picture', 'picture_id'); }
	public function slugs() { return $this->morphMany('\CityByCitizen\Slug', 'sluggable'); }
	#endregion
}
