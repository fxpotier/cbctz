<?php
/**
 * Created by PhpStorm.
 * User: Hinomi
 * Date: 05/05/2015
 * Time: 01:51
 */

namespace CityByCitizen;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Token extends Model {
	#region configuration
	/**
	 * The database table used by the model.
	 * @var string
	 */
	protected $table = 'tokens';

	/**
	 * The attributes that are mass assignable.
	 * @var array
	 */
	protected $fillable = ['expiration_date', 'token', 'type'];

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
	#endregion

	#region scopes
	public function scopeByType(Builder $query, $type) {
		return $query->where('type', $type);
	}

	public function scopeOwnedBy(Builder $query, Account $account) {
		return $query->where('account_id', $account->id);
	}

	public function scopeValid(Builder $query) {
		return $query->where('expiration_date', '>=', Carbon::now());
	}
	#endregion
}