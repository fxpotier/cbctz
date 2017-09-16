<?php
/**
 * Created by PhpStorm.
 * User: Romain
 * Date: 24/06/2015
 * Time: 10:15
 */

namespace CityByCitizen\Services;
define('MANGO_PRODUCTION', config('services.mangopay.production'));

class MangoPay extends \ThunderArrow\MangoPay\MangoPay {

    function __construct() {
        parent::__construct(config('services.mangopay.clientid'), config('services.mangopay.passphrase'));
    }
}