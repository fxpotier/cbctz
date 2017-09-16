<?php
/**
 * Created by PhpStorm.
 * User: Hinomi
 * Date: 20/05/2015
 * Time: 15:58
 */

namespace CityByCitizen\Services;

use CityByCitizen\Address;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use ThunderArrow\Rest\RestRequest;
use ThunderArrow\Validation\Services\SuperValidator;

class AddressManager {

	/**
	 * @param $data
	 * @return Address
	 */
	public function Create($data) {
		$address = new Address($data);
		$address = $this->Complete($address);
		if($address['addressable_type']) return $this->Copy($address);
		return $address;
    }

	/**
	 * @param Address $address
	 * @return Address
	 */
	public function Complete(Address $address) {
		$geocode = $this->Geocode($address);
		if($geocode != null) {
			$address = $geocode;
			$address->save();
		}
		else {
			$locate = $this->Locate($address);
			if($locate != null) $locate->save();
		}

		$timezone = $this->FindTimeZone($address);
		if($timezone != null) {
			$address = $timezone;
			$address->save();
		}

		if($address->timezone == null) $address->timezone = 0;
		if($address->latitude == null) $address->latitude = 0;
		if($address->longitude == null) $address->longitude = 0;


		return $address;
	}

	/**
	 * @param $address
	 * @return Address
	 */
	public function Copy($address) {
		return new Address([
			'street' => $address['street'],
			'city' => $address['city'],
			'zipcode' => $address['zipcode'],
			'country' => $address['country'],
			'timezone' => $address['timezone'],
			'latitude' => $address['latitude'],
			'longitude' => $address['longitude'],
		]);
	}

	/**
	 * @param Address $address
	 * @return \CityByCitizen\Address
	 */
	public function Locate(Address $address) {
		if(!config('cbc.google-api-key')) return null;
		$findAddress = $this->Find($address);
		if($findAddress) $address = $findAddress;
		if(($address['city'] && $address['zipcode']&& $address['country']) || !$address->latitude || !$address->longitude) return null;

		$response = $this->GoogleApiRequest([
			'latlng' => $address->latitude.','.$address->longitude,
			'key' => config('cbc.google-api-key')
		], 'geocode', $address);
		if(!$response) return null;
        if ($this->GoogleMapError($response, $address)) return null;

		$address = $this->GoogleCompleteAddress($response, $address);

		$findAddress = $this->Find($address);
		if(!$findAddress) return $address;
		return null;
	}

	/**
	 * @param Address $address
	 * @return \CityByCitizen\Address
	 */
	public function Geocode(Address $address) {
		if(!config('cbc.google-api-key')) return null;
		$findAddress = $this->Find($address);
		if($findAddress) $address = $findAddress;

		if($address->latitude && $address->longitude) return null;

		$response = $this->GoogleApiRequest([
			'address' => urlencode($address->street.' '.$address->zipcode.' '.$address->city),
		    'components' => 'country:'.urlencode($address->country),
			'key' => config('cbc.google-api-key')
		], 'geocode', $address);
		if(!$response) return null;
        if($this->GoogleMapError($response, $address)) return null;
		$address = $this->GoogleCompleteAddress($response, $address);

		return $address;
	}

	/**
	 * @param Address $address
	 * @return \CityByCitizen\Address
	 */
	public function FindTimeZone(Address $address) {
		$findAddress = $this->Find($address);
		if($findAddress) $address = $findAddress;
		if($address->timezone) return $address;
		if(!config('cbc.google-api-key')) return null;
		$response = $this->GoogleApiRequest([
			'location' => $address->latitude.','.$address->longitude,
			'timestamp' => '0',
			'language' => $address->country,
			'key' => config('cbc.google-api-key')
		], 'timezone', $address);
		if(!$response) return null;
		if($this->GoogleMapError($response, $address)) return null;
		$address['timezone'] = $response->body->rawOffset;
		return $address;
	}

	/**
	 * @param $parameters
	 * @param $type
	 * @param Address $address
	 * @return bool|\ThunderArrow\Rest\RestResponse
	 */
	private function GoogleApiRequest($parameters, $type, Address $address) {
		$req = RestRequest::post('https://maps.googleapis.com/maps/api/'.$type.'/json')
			->setHeader('Content-Type', 'application/x-www-form-urlencoded');
		foreach($parameters as $key => $parameter) $req->setQueryParameter($key, $parameter);
		$response = $req->send();
		if($this->GoogleMapError($response, $address)) return false;
		return $response;
	}

	/**
	 * @param $response
	 * @param Address $address
	 * @return Address
	 */
	private function GoogleCompleteAddress($response, Address $address) {
		$newStreet = false;
		if(!$address['street']) {
			$address['street'] = '';
			$newStreet = true;
		}
		//TODO Gérer erreur, geocoder ville si zero result.
		if(!$response->body->results) return null;
		$addressComponents =  $response->body->results[0]->address_components;
		foreach($addressComponents as $component) {
			if($component->types[0] == 'street_number' && $newStreet) $address['street'] = $component->long_name.' ';
			else if($component->types[0] == 'route' && $newStreet) $address['street'] .= $component->long_name;
			else if($component->types[0] == 'locality' && !$address['city']) $address['city'] = $component->long_name;
			else if($component->types[0] == 'country' && !$address['country']) $address['country'] = $component->long_name;
			else if($component->types[0] == 'postal_code' && !$address['zipcode']) $address['zipcode'] .= $component->long_name;
		}

		$location = $response->body->results[0]->geometry->location;
		if(!$address['latitude']) $address['latitude'] = $location->lat;
		if(!$address['longitude']) $address['longitude'] = $location->lng;

		return $address;
	}

	/**
	 * @param $response
	 * @param Address $address
	 * @return null
	 */
	private function GoogleMapError($response, Address $address) {
		$status = $response->body->status;
		if($status != 'OK' && $status != 'ZERO_RESULTS') {
			$errorMessage = 'Google map api failure | status: ' . $status;
			$errorMessage .= isset($response->body->error_message) ? ' | error message: ' . $response->body->error_message : '';
			$this->LogError($errorMessage, $address);
			return true;
		}
		return false;
	}

	/**
	 * @param $message
	 * @param Address $address
	 */
	private function LogError($message, Address $address) {
		Log::error($message, [
			'street' => $address['street'],
			'city' => $address['city'],
			'zipcode' => $address['zipcode'],
			'country' => $address['country'],
			'latitude' => $address['latitude'],
			'longitude' => $address['longitude'],
		]);
	}

	/**
	 * @param Address $address
	 * @return mixed
	 */
	public function Find(Address $address) {
		if($address->latitude) $address->latitude = round($address->latitude, 5);
		if($address->longitude) $address->longitude = round($address->longitude, 5);

		$attributes = $address->attributesToArray();
		unset($attributes['id']);
		unset($attributes['addressable_id']);
		unset($attributes['addressable_type']);
		return Address::where($attributes)->first();
	}

	/**
	 * @param $data
	 * @return array
	 */
	public function FindByQuery($data) {
		// 1. Check string in cities, return suggestions
		// 2. check full address if enabled
		// 3. in not found use google to geocode, and return geocoded addresses (store in database)

		if($data instanceof Collection) {
			$addresses = [];
			foreach($data as $query) $addresses[] = $this->FindByQuery($query);
			return $addresses;
		}
	}

    /**
     * @param Address $address
     * @param Model $model
     * @param string $relation relation name if not the standard 'address'
     */
    public function AddAddress(Address $address, Model $model, $relation = '') {
        if ($relation === '') $model->address()->save($address);
        else $model->$relation()->save($address);
    }

	  /**
     * @param Address $address
     * @param $data
     */
    public function UpdateAddress(Address $address, $data) {
		$address->street = $data['street'];
		$address->zipcode = $data['zipcode'];
		$address->city = $data['city'];
		$address->country = $data['country'];
		$address->save();
	}

    public function UpdateOrCreateAddress($address, $data) {
		if($address == null) {
			return $this->Create($data);
		}
		$address->latitude = null;
		$address->longitude = null;
		$address->timezone = null;
		$address->street = $data['street'];
		$address->zipcode = $data['zipcode'];
		$address->city = $data['city'];
		$address->country = $data['country'];
		$address->save();
        return $this->Complete($address);
    }
}
