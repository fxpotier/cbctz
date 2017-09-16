<?php namespace CityByCitizen;

use Carbon\Carbon;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {
	#region configuration
	use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 * @var array
	 */
	protected $fillable = ['firstname', 'lastname'];

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
	public function account() { return $this->belongsTo('\CityByCitizen\Account'); }
	public function mainLanguage() { return $this->belongsTo('\CityByCitizen\Language', 'main_language_id', 'id'); }
	public function displayLanguage() { return $this->belongsTo('\CityByCitizen\Language', 'display_language_id', 'id'); }
	public function coverPicture() { return $this->belongsTo('\CityByCitizen\Picture', 'cover_picture_id'); }
	public function profilePicture() { return $this->belongsTo('\CityByCitizen\Picture', 'profile_picture_id'); }
    public function payment() {return $this->hasOne('\CityByCitizen\Payment');}
	public function articles() { return $this->hasMany('\CityByCitizen\Article'); }
	public function notifications() { return $this->hasMany('\CityByCitizen\Notification'); }
	public function agenda() { return $this->hasMany('\CityByCitizen\Event'); }
	public function travelsAsTraveler() { return $this->hasMany('\CityByCitizen\Travel', 'traveler_id'); }
	public function travelsAsCitizen() { return $this->hasMany('\CityByCitizen\Travel', 'citizen_id'); }
	public function experiences() { return $this->hasMany('\CityByCitizen\Experience'); }
	public function authorFeedbacks() { return $this->hasMany('\CityByCitizen\Feedback'); }
	public function languages() { return $this->belongsToMany('\CityByCitizen\Language'); }
	public function address() { return $this->morphOne('\CityByCitizen\Address', 'addressable'); }
	public function feedbackStats() { return $this->morphOne('\CityByCitizen\FeedbackStat', 'feedbackable'); }
	public function description() { return $this->morphMany('\CityByCitizen\Description', 'describable'); }
	public function feedbacksReceived() { return $this->morphMany('\CityByCitizen\Feedback', 'feedbackable'); }
	public function pictures() { return $this->morphMany('\CityByCitizen\Picture', 'picturable'); }
	public function slug() { return $this->morphMany('\CityByCitizen\Slug', 'sluggable'); }
	public function tags() { return $this->morphToMany('\CityByCitizen\Tag', 'taggable'); }
	public function specialRequestsAsked() { return $this->hasMany('\CityByCitizen\SpecialRequests', 'special_request_id', 'user_id'); }
	public function specialRequestsReceived() { return $this->belongsToMany('\CityByCitizen\SpecialRequests', 'user_special_request', 'user_id', 'special_request_id'); }
	#endregion

	#region Mutators
	public function getBirthdateAttribute($value) {
		return Carbon::parse($value);
	}
	#endregion
}