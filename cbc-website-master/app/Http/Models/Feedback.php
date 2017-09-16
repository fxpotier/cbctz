<?php namespace CityByCitizen;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model {
	#region configuration
	/**
	 * The database table used by the model.
	 * @var string
	 */
	protected $table = 'feedbacks';

	/**
	 * The attributes that are mass assignable.
	 * @var array
	 */
	protected $fillable = ['value','content'];

	/**
	 * The attributes excluded from the model's JSON form.
	 * @var array
	 */
	protected $hidden = [];
	#endregion

	#region relationships
	public function author() { return $this->belongsTo('\CityByCitizen\User' , 'user_id'); }
	public function feedbackable() { return $this->morphTo(); }
	#endregion
}
