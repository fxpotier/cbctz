<?php namespace CityByCitizen;

use Illuminate\Database\Eloquent\Model;

class Picture extends Model {
	#region configuration
	/**
	 * The database table used by the model.
	 * @var string
	 */
	protected $table = 'pictures';

	/**
	 * The attributes that are mass assignable.
	 * @var array
	 */
	protected $fillable = ['source', 'source_thumbnail', 'album'];

	/**
	 * The attributes excluded from the model's JSON form.
	 * @var array
	 */
	protected $hidden = ['picturable_id', 'picturable_type'];

	/**
	 * Timestamps management.
	 * @var bool
	 */
	public $timestamps = false;
	#endregion

	#region relationships
	public function picturable() { return $this->morphTo(); }
	#endregion

	//region Scopes
	public function scopeOwnedBy($query, $item) {
		return $query->wherePicturableId($item->id)->wherePicturableType(get_class($item));
	}
	//endregion
}
