<?php
/**
 * Created by PhpStorm.
 * User: Romain
 * Date: 06/07/2015
 * Time: 11:04
 */

namespace CityByCitizen;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model{
    #region configuration
    /**
     * The database table used by the model.
     * @var string
     */
    protected $table = 'payments';

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = ['user_mango_id', 'wallet_id','bank_id'];

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
    public function user() { return $this->belongsTo('\CityByCitizen\User'); }
    #endregion
}