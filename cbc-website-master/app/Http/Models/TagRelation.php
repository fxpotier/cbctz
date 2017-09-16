<?php namespace CityByCitizen;

use Illuminate\Database\Eloquent\Model;

class TagRelation extends Model {
	#region configuration
	/**
	 * The database table used by the model.
	 * @var string
	 */
	protected $table = 'tag_relations';

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
	public function referenceTag() { return $this->hasOne('\CityByCitizen\Tag', 'id', 'reference_tag_id'); }
	public function relatedTag() { return $this->hasOne('\CityByCitizen\Tag', 'id', 'related_tag_id'); }
	#endregion
}
