<?php namespace CityByCitizen;

use Illuminate\Database\Eloquent\Model;

class Description extends Model {
	#region configuration
	/**
	 * The database table used by the model.
	 * @var string
	 */
	protected $table = 'descriptions';

	/**
	 * The attributes that are mass assignable.
	 * @var array
	 */
	protected $fillable = ['title', 'content','describable_id','describable_type'];

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
	public function describable() { return $this->morphTo(); }
	public function translation() { return $this->morphMany('\CityByCitizen\Translation', 'translatable'); }
	#endregion
}
