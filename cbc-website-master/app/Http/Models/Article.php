<?php namespace CityByCitizen;

use Illuminate\Database\Eloquent\Model;

class Article extends Model {
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
	public function author() { return $this->belongsTo('\CityByCitizen\User'); }
    public function coverPicture() { return $this->belongsTo('\CityByCitizen\Picture'); }
	public function translations() { return $this->morphMany('\CityByCitizen\Translation', 'translatable'); }
	public function slugs() { return $this->morphMany('\CityByCitizen\Slug', 'sluggable'); }
	public function comments() { return $this->morphMany('\CityByCitizen\Comment', 'commentable'); }
	public function rates() { return $this->morphMany('\CityByCitizen\Rate', 'ratable'); }
	public function tags() { return $this->morphToMany('\CityByCitizen\Tag', 'taggable'); }
	#endregion
}
