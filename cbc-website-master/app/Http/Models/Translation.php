<?php namespace CityByCitizen;

use Illuminate\Database\Eloquent\Model;

class Translation extends Model {
	#region configuration
	/**
	 * The database table used by the model.
	 * @var string
	 */
	protected $table = 'translations';

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
	public function language() { return $this->belongsTo('\CityByCitizen\Language'); }
	public function translatable() { return $this->morphTo(); }
	#endregion
}
