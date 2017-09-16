<?php namespace CityByCitizen;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Experience extends Model {
	#region configuration
	use SoftDeletes;
	protected $dates = ['deleted_at'];

	/**
	 * The database table used by the model.
	 * @var string
	 */
	protected $table = 'experiences';

	/**
	 * The attributes that are mass assignable.
	 * @var array
	 */
	protected $fillable = [
		'duration',
		'min_persons',
		'max_persons',
		'incurred_cost',
		'incurred_transportation_cost',
		'incurred_food_drink_cost',
		'incurred_ticket_cost',
		'incurred_other_cost',
		'incurred_cost_per_person',
		'incurred_transportation_cost_per_person',
		'incurred_food_drink_cost_per_person',
		'incurred_ticket_cost_per_person',
		'incurred_other_cost_per_person',
		'suggested_tip',
		'is_experience_per_person',
		'state'
	];

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

	#region scopes
	public function scopeOfState($query, $state){
		return $query->whereState($state);
	}
	#endregion

	#region relationships

	public function coverPicture() { return $this->belongsTo('\CityByCitizen\Picture', 'cover_picture_id'); }
	public function thumbnailPicture() { return $this->belongsTo('\CityByCitizen\Picture', 'thumbnail_picture_id'); }
	public function area() { return $this->belongsTo('\CityByCitizen\Area'); }
	public function citizen() { return $this->belongsTo('\CityByCitizen\User', 'user_id'); }
	public function partner() { return $this->belongsTo('\CityByCitizen\Partner'); }
	public function agenda() { return $this->hasMany('\CityByCitizen\Event'); }
	public function travels() { return $this->hasMany('\CityByCitizen\Travel', 'experience_id'); }
	public function periods() { return $this->hasMany('\CityByCitizen\Period'); }
	public function languages() { return $this->belongsToMany('\CityByCitizen\Language')->withPivot(['id']); }
	public function travelers() { return $this->hasManyThrough('\CityByCitizen\User', '\CityByCitizen\Travel'); }
	public function feedbacks() { return $this->hasManyThrough('\CityByCitizen\Feedback', '\CityByCitizen\Travel', null, 'feedbackable_id')->whereFeedbackableType(Travel::class)->orderBy('created_at','desc');}
	public function meetingPoint() { return $this->morphOne('\CityByCitizen\Address', 'addressable'); }
	public function description() { return $this->morphOne('\CityByCitizen\Description', 'describable'); }
	public function feedbackStats() { return $this->morphOne('\CityByCitizen\FeedbackStat', 'feedbackable'); }
	public function pictures() { return $this->morphMany('\CityByCitizen\Picture', 'picturable'); }
	public function descriptionPictures() { return $this->morphMany('\CityByCitizen\Picture', 'picturable')->where('album', 'description'); }
	public function translations() { return $this->morphMany('\CityByCitizen\Translation', 'translatable'); }
	public function slug() { return $this->morphMany('\CityByCitizen\Slug', 'sluggable'); }
	public function tags() { return $this->morphToMany('\CityByCitizen\Tag', 'taggable'); }
	#endregion
}